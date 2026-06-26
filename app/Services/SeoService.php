<?php

namespace App\Services;

use App\Models\SeoMeta;
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

    public function routeKeyFromRequest(?Request $request = null): string
    {
        $request ??= request();
        $routeName = Route::currentRouteName();

        return match ($routeName) {
            'website.home' => 'home',
            'website.about' => 'about',
            'website.team' => 'team',
            'website.contact' => 'contact',
            'website.pricing' => 'pricing',
            'website.faq' => 'faq',
            'website.portfolio' => 'portfolio',
            'website.blog' => 'blog',
            'website.blog.show' => 'blog:'.$request->route('slug'),
            'website.services.index' => 'services',
            'website.services.show' => 'service:'.$request->route('slug'),
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
        $siteName = config('website.name', 'Sparkxe');

        $seo->meta_title = filled($seo->meta_title)
            ? $seo->meta_title
            : ($seo->page_label.' - '.$siteName);

        $seo->meta_description = filled($seo->meta_description)
            ? $seo->meta_description
            : config('website.description');

        $seo->meta_keywords = filled($seo->meta_keywords)
            ? $seo->meta_keywords
            : 'sparkxe, digital marketing, web development, software';

        $seo->og_title = filled($seo->og_title) ? $seo->og_title : $seo->meta_title;
        $seo->og_description = filled($seo->og_description) ? $seo->og_description : $seo->meta_description;

        $seo->setAttribute('canonical_url_resolved', $this->getCanonicalUrl($seo, $request));

        if (blank($seo->schema_json) && $seo->schema_type !== 'none') {
            $seo->schema_json = $this->buildSchemaJson($seo);
        }

        return $seo;
    }

    public function getCanonicalUrl(SeoMeta $seo, ?Request $request = null): string
    {
        if (filled($seo->canonical_url)) {
            return $seo->canonical_url;
        }

        $request ??= request();

        return url($request->path());
    }

    public function buildSchema(SeoMeta $seo): ?array
    {
        if ($seo->schema_type === 'none') {
            return null;
        }

        $url = $this->getCanonicalUrl($seo);
        $siteName = config('website.name', 'Sparkxe');

        return match ($seo->schema_type) {
            'FAQPage' => [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'name' => $seo->meta_title ?? $seo->page_label,
                'description' => $seo->meta_description,
                'url' => $url,
            ],
            'Organization' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $siteName,
                'url' => config('app.url'),
                'description' => $seo->meta_description,
            ],
            default => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $seo->meta_title ?? $seo->page_label,
                'description' => $seo->meta_description,
                'url' => $url,
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
            'meta_keywords' => 'sparkxe, digital marketing, software, web design',
            'focus_keyword' => 'sparkxe',
            'h1_heading' => config('website.name'),
            'robots_index' => true,
            'robots_follow' => true,
            'schema_type' => 'Organization',
        ]));
    }

    public function routeKeySuggestions(): array
    {
        $suggestions = [
            'home' => 'Home (/new-website)',
            'about' => 'About (/new-website/about)',
            'team' => 'Team (/new-website/team)',
            'contact' => 'Contact (/new-website/contact)',
            'pricing' => 'Pricing (/new-website/pricing)',
            'faq' => 'FAQ (/new-website/faq)',
            'portfolio' => 'Portfolio (/new-website/portfolio)',
            'blog' => 'Blog (/new-website/blog)',
            'services' => 'All Services (/new-website/services)',
        ];

        foreach (config('website.services', []) as $service) {
            $suggestions['service:'.$service['slug']] = $service['title'].' (/new-website/services/'.$service['slug'].')';
        }

        return $suggestions;
    }
}
