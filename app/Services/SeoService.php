<?php

namespace App\Services;

use App\Models\SeoMeta;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SeoService
{
    public function normalizeUrlSlug(string $input): string
    {
        $input = trim($input);

        if ($input === '') {
            return '/';
        }

        if (filter_var($input, FILTER_VALIDATE_URL)) {
            $path = parse_url($input, PHP_URL_PATH) ?? '/';
        } else {
            $path = str_starts_with($input, '/') ? $input : '/'.$input;
        }

        $path = '/'.trim($path, '/');

        return $path === '/' ? '/' : $path;
    }

    public function currentRequestPath(?Request $request = null): string
    {
        $request ??= request();

        return $this->normalizeUrlSlug($request->path());
    }

    public function publicDomain(): string
    {
        return rtrim((string) config('website.domain', 'https://sparkxe.com'), '/');
    }

    public function publicUrl(?string $path = null): string
    {
        $path = $this->normalizeUrlSlug($path ?? '/');

        return $path === '/'
            ? $this->publicDomain()
            : $this->publicDomain().$path;
    }

    public function routeKeyFromRequest(?Request $request = null): string
    {
        $request ??= request();
        $routeName = Route::currentRouteName();

        return match ($routeName) {
            'website.home', 'home' => 'home',
            'website.about' => 'about',
            'website.team' => 'team',
            'website.contact' => 'contact',
            'website.pricing' => 'pricing',
            'website.faq' => 'faq',
            'website.portfolio' => 'portfolio',
            'website.privacy' => 'privacy',
            'website.cookies' => 'cookies',
            'website.blog' => 'blog',
            'website.blog.show' => 'blog:'.$request->route('slug'),
            'website.services.index' => 'services',
            'website.services.show' => 'service:'.$request->route('slug'),
            'website.products.show' => 'product:'.$request->route('slug'),
            default => 'home',
        };
    }

    public function resolveForRequest(?Request $request = null): SeoMeta
    {
        $request ??= request();
        $currentPath = $this->currentRequestPath($request);

        $seo = SeoMeta::query()->forUrlSlug($currentPath)->first();

        if (! $seo) {
            $routeKey = $this->routeKeyFromRequest($request);
            $seo = SeoMeta::query()->forRouteKey($routeKey)->first();
        }

        if ($seo) {
            return $this->applyRuntimeDefaults($seo, $request);
        }

        return $this->defaultSeo($currentPath);
    }

    public function applyRuntimeDefaults(SeoMeta $seo, ?Request $request = null): SeoMeta
    {
        $request ??= request();
        $company = config('website.name', 'Sparkxe Technologies');
        $shortName = config('website.short_name', 'Sparkxe');
        $routeKey = $seo->route_key ?: $this->routeKeyFromRequest($request);
        $isHome = $routeKey === 'home' || $routeKey === 'default';

        $seo->meta_title = filled($seo->meta_title)
            ? $this->normalizeBrandTitle((string) $seo->meta_title, $company, $shortName)
            : ($seo->page_label.' — '.$company);

        $seo->meta_description = filled($seo->meta_description)
            ? $seo->meta_description
            : config('website.description');

        $seo->meta_keywords = filled($seo->meta_keywords)
            ? $seo->meta_keywords
            : config('website.seo.default_keywords');

        $seo = $this->enrichWithAiSeo($seo, $routeKey);

        if ($isHome) {
            $seo->og_title = filled($seo->og_title) ? $seo->og_title : $shortName;
            $seo->og_description = filled($seo->og_description)
                ? $seo->og_description
                : config('website.tagline', 'Custom Software Development Company');
            $seo->setAttribute('twitter_title', $shortName);
            $seo->setAttribute('twitter_description', config('website.twitter_tagline', 'Software Development Company'));
        } else {
            $seo->og_title = filled($seo->og_title) ? $seo->og_title : $seo->meta_title;
            $seo->og_description = filled($seo->og_description) ? $seo->og_description : $seo->meta_description;
            $seo->setAttribute('twitter_title', $seo->og_title);
            $seo->setAttribute('twitter_description', $seo->og_description);
        }

        $seo->setAttribute('og_type', config('website.seo.og_type', 'website'));
        $seo->setAttribute('twitter_card', config('website.seo.twitter_card', 'summary_large_image'));
        $seo->setAttribute('og_site_name', $company);
        $seo->setAttribute('canonical_url_resolved', $this->getCanonicalUrl($seo, $request));
        $seo->setAttribute('og_image_resolved', $this->resolveOgImage($seo));
        $seo->setAttribute('og_url_resolved', $seo->getAttribute('canonical_url_resolved'));

        if (blank($seo->schema_json) && $seo->schema_type !== 'none') {
            $seo->schema_json = $this->buildSchemaJson($seo);
        }

        return $seo;
    }

    /**
     * Dynamically enrich page SEO with AI SEO, AEO, and GEO signals.
     */
    public function enrichWithAiSeo(SeoMeta $seo, string $routeKey): SeoMeta
    {
        $aiKeywords = $this->aiKeywordsForRoute($routeKey);
        $existing = collect(explode(',', (string) $seo->meta_keywords))
            ->map(fn (string $keyword) => trim(mb_strtolower($keyword)))
            ->filter()
            ->values();

        $merged = $existing
            ->merge($aiKeywords)
            ->unique()
            ->take(24)
            ->implode(', ');

        $seo->meta_keywords = $merged;

        if (blank($seo->focus_keyword)) {
            $seo->focus_keyword = $aiKeywords[0] ?? 'ai seo aeo geo sparkxe';
        }

        $description = (string) $seo->meta_description;
        $aiCue = $this->aiDescriptionCue($routeKey);
        $needsAiCue = $aiCue !== '' && ! preg_match('/\b(ai seo|aeo|geo|answer engine|generative engine)\b/i', $description);

        if ($needsAiCue) {
            $seo->meta_description = rtrim($description, '. ').'. '.$aiCue;
        }

        if (mb_strlen((string) $seo->meta_description) > 165) {
            $seo->meta_description = rtrim(mb_substr((string) $seo->meta_description, 0, 162)).'...';
        }

        return $seo;
    }

    protected function normalizeBrandTitle(string $title, string $company, string $shortName): string
    {
        $title = trim($title);

        if (str_contains($title, $company) || str_contains($title, $shortName)) {
            return str_replace(
                [' — Sparkxe', ' - Sparkxe', ' | Sparkxe', 'Sparkxe —', 'Sparkxe -'],
                [' — '.$company, ' - '.$company, ' | '.$company, $company.' —', $company.' -'],
                $title
            );
        }

        return $title.' — '.$company;
    }

    protected function aiKeywordsForRoute(string $routeKey): array
    {
        $base = [
            'sparkxe technologies',
            'sparkxe.com',
            'ai seo',
            'ai seo aeo geo',
            'answer engine optimization',
            'generative engine optimization',
            'aeo',
            'geo seo',
            'custom software development company',
        ];

        return match (true) {
            $routeKey === 'home' => array_merge($base, [
                'sparkxe',
                'software development company',
                'ai powered digital agency',
            ]),
            $routeKey === 'about' => array_merge($base, [
                'about sparkxe technologies',
                'ai digital agency india',
            ]),
            $routeKey === 'services', str_starts_with($routeKey, 'service:') => array_merge($base, [
                'ai seo services',
                'aeo services',
                'geo optimization services',
                'ai chatbot development',
            ]),
            $routeKey === 'contact' => [
                'contact sparkxe technologies',
                'sparkxe.com contact',
                'ai seo consultation',
            ],
            $routeKey === 'blog', str_starts_with($routeKey, 'blog:') => [
                'ai seo tips',
                'aeo content strategy',
                'geo ranking insights',
            ],
            $routeKey === 'faq' => ['sparkxe faq', 'ai seo faq', 'aeo geo questions'],
            $routeKey === 'privacy' => ['sparkxe technologies privacy policy', 'ai data privacy'],
            $routeKey === 'cookies' => ['sparkxe cookie policy', 'sparkxe.com cookies'],
            default => $base,
        };
    }

    protected function aiDescriptionCue(string $routeKey): string
    {
        return match (true) {
            $routeKey === 'home' => 'Specialists in AI SEO, AEO, and GEO for modern search visibility.',
            $routeKey === 'about' => 'Built around AI SEO (AEO / GEO) and measurable digital growth.',
            $routeKey === 'services', str_starts_with($routeKey, 'service:') => 'Optimized with AI SEO, Answer Engine Optimization (AEO), and Generative Engine Optimization (GEO).',
            $routeKey === 'contact' => 'Talk to Sparkxe Technologies about AI SEO, AEO, GEO, and custom software.',
            $routeKey === 'blog' => 'Guides on AI SEO, AEO, GEO, and software growth.',
            default => '',
        };
    }

    public function getCanonicalUrl(SeoMeta $seo, ?Request $request = null): string
    {
        if (filled($seo->canonical_url)) {
            return $seo->canonical_url;
        }

        $request ??= request();

        return $this->publicUrl($this->currentRequestPath($request));
    }

    public function resolveOgImage(SeoMeta $seo): string
    {
        if (filled($seo->og_image)) {
            if (str_starts_with((string) $seo->og_image, 'http://') || str_starts_with((string) $seo->og_image, 'https://')) {
                return (string) $seo->og_image;
            }

            return $this->publicDomain().'/'.ltrim((string) $seo->og_image, '/');
        }

        $configured = (string) config('website.seo.og_image', 'https://sparkxe.com/images/og-image.jpg');

        if (filled($configured)) {
            return $configured;
        }

        $logo = SiteSetting::websiteNavLogoUrl();

        if (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')) {
            return $logo;
        }

        return $this->publicDomain().'/'.ltrim(parse_url($logo, PHP_URL_PATH) ?: $logo, '/');
    }

    public function buildSchema(SeoMeta $seo): ?array
    {
        if ($seo->schema_type === 'none') {
            return null;
        }

        $url = $this->getCanonicalUrl($seo);
        $company = config('website.name', 'Sparkxe Technologies');
        $shortName = config('website.short_name', 'Sparkxe');
        $domain = $this->publicDomain();
        $logo = $this->resolveOgImage($seo);

        return match ($seo->schema_type) {
            'FAQPage' => [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'name' => $seo->meta_title ?? $seo->page_label,
                'description' => $seo->meta_description,
                'url' => $url,
                'isPartOf' => [
                    '@type' => 'WebSite',
                    'name' => $company,
                    'url' => $domain,
                ],
            ],
            'Organization' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $company,
                'alternateName' => $shortName,
                'url' => $domain,
                'logo' => $logo,
                'email' => config('website.email'),
                'telephone' => config('website.phone'),
                'description' => $seo->meta_description,
                'sameAs' => array_values(array_filter([
                    config('website.social.instagram'),
                    config('website.social.facebook'),
                ])),
                'knowsAbout' => [
                    'Custom Software Development',
                    'AI SEO',
                    'Answer Engine Optimization (AEO)',
                    'Generative Engine Optimization (GEO)',
                    'Digital Marketing',
                    'Mobile Apps',
                    'ERP Software',
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1/25-2, North Street, Kurunjcheri',
                    'addressLocality' => 'Udumalpet',
                    'addressRegion' => 'Tamil Nadu',
                    'postalCode' => '642154',
                    'addressCountry' => 'IN',
                ],
            ],
            default => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $seo->meta_title ?? $seo->page_label,
                'description' => $seo->meta_description,
                'url' => $url,
                'isPartOf' => [
                    '@type' => 'WebSite',
                    'name' => $company,
                    'url' => $domain,
                ],
                'about' => [
                    '@type' => 'Thing',
                    'name' => 'AI SEO, AEO, GEO and custom software development',
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $company,
                    'url' => $domain,
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $logo,
                    ],
                ],
            ],
        };
    }

    public function buildSchemaJson(SeoMeta $seo): ?string
    {
        if (filled($seo->schema_json)) {
            return $seo->schema_json;
        }

        $schema = $this->buildSchema($seo);

        if ($schema === null) {
            return null;
        }

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function defaultSeo(?string $currentPath = null): SeoMeta
    {
        return $this->applyRuntimeDefaults(new SeoMeta([
            'route_key' => 'default',
            'url_slug' => $currentPath,
            'page_label' => 'Home',
            'meta_title' => config('website.title'),
            'meta_description' => config('website.description'),
            'meta_keywords' => config('website.seo.default_keywords'),
            'focus_keyword' => 'sparkxe technologies',
            'h1_heading' => config('website.short_name', 'Sparkxe'),
            'robots_index' => true,
            'robots_follow' => true,
            'schema_type' => 'Organization',
        ]));
    }

    public function routeKeySuggestions(): array
    {
        $suggestions = [
            'home' => 'Home (/)',
            'about' => 'About (/about)',
            'team' => 'Team (/team)',
            'contact' => 'Contact (/contact)',
            'pricing' => 'Pricing (/pricing)',
            'faq' => 'FAQ (/faq)',
            'portfolio' => 'Portfolio (/portfolio)',
            'privacy' => 'Privacy Policy (/privacy-policy)',
            'cookies' => 'Cookie Policy (/cookie-policy)',
            'blog' => 'Blog (/blog)',
            'services' => 'All Services (/services)',
        ];

        foreach (config('website.services', []) as $service) {
            $suggestions['service:'.$service['slug']] = $service['title'].' (/services/'.$service['slug'].')';
        }

        return $suggestions;
    }
}
