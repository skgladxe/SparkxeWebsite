<?php

namespace Database\Seeders;

use App\Models\SeoMeta;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        $company = 'Sparkxe Technologies';
        $domain = 'https://sparkxe.com';
        $ogImage = $domain.'/images/og-image.jpg';

        $pages = [
            [
                'route_key' => 'home',
                'url_slug' => '/',
                'page_label' => 'Home',
                'meta_title' => $company.' — Custom Software Development Company',
                'meta_description' => 'Sparkxe Technologies (sparkxe.com) — custom software development company specializing in AI SEO, AEO, GEO, digital marketing, mobile apps, e-commerce, and ERP.',
                'meta_keywords' => 'sparkxe, sparkxe technologies, sparkxe.com, custom software development company, ai seo, aeo, geo',
                'focus_keyword' => 'sparkxe technologies',
                'h1_heading' => 'Smart Software for Seamless Business Growth',
                'og_title' => 'Sparkxe',
                'og_description' => 'Custom Software Development Company',
                'og_image' => $ogImage,
                'canonical_url' => $domain,
                'schema_type' => 'Organization',
                'sitemap_priority' => 1.0,
            ],
            [
                'route_key' => 'about',
                'url_slug' => '/about',
                'page_label' => 'About Us',
                'meta_title' => 'About Sparkxe Technologies — Digital Growth Partner',
                'meta_description' => 'About Sparkxe Technologies (sparkxe.com) — a custom software and AI SEO (AEO / GEO) company for marketing, software, web, and design.',
                'meta_keywords' => 'about sparkxe technologies, sparkxe.com, ai seo agency, software company',
                'focus_keyword' => 'about sparkxe technologies',
                'h1_heading' => 'Your partner for end-to-end growth',
                'og_title' => 'About Sparkxe Technologies',
                'og_description' => 'Custom software, AI SEO, AEO, and GEO from Sparkxe Technologies.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.8,
            ],
            [
                'route_key' => 'team',
                'url_slug' => '/team',
                'page_label' => 'Our Team',
                'meta_title' => 'Our Team — Sparkxe Technologies',
                'meta_description' => 'Meet the Sparkxe Technologies team — developers, designers, and marketers helping businesses grow with AI SEO and custom software.',
                'meta_keywords' => 'sparkxe technologies team, sparkxe.com team, digital agency team',
                'focus_keyword' => 'sparkxe technologies team',
                'h1_heading' => 'Experts behind Sparkxe',
                'og_title' => 'Our Team — Sparkxe Technologies',
                'og_description' => 'Experts behind Sparkxe Technologies at sparkxe.com.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'services',
                'url_slug' => '/services',
                'page_label' => 'All Services',
                'meta_title' => 'Our Services — Sparkxe Technologies',
                'meta_description' => 'Explore Sparkxe Technologies services — AI SEO (AEO / GEO), digital marketing, POS, ERP, mobile apps, e-commerce, design, and hosting.',
                'meta_keywords' => 'sparkxe technologies services, ai seo services, aeo, geo, custom software',
                'focus_keyword' => 'sparkxe technologies services',
                'h1_heading' => 'Everything your business needs to win online',
                'og_title' => 'Services — Sparkxe Technologies',
                'og_description' => 'AI SEO, AEO, GEO, software, and digital growth services.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.9,
            ],
            [
                'route_key' => 'contact',
                'url_slug' => '/contact',
                'page_label' => 'Contact Us',
                'meta_title' => 'Contact Sparkxe Technologies — Get a Free Quote',
                'meta_description' => 'Contact Sparkxe Technologies (sparkxe.com) for custom software, AI SEO, AEO, GEO, marketing, and design. Free consultation within 24 hours.',
                'meta_keywords' => 'contact sparkxe technologies, sparkxe.com contact, ai seo quote',
                'focus_keyword' => 'contact sparkxe technologies',
                'h1_heading' => "Let's discuss your next project",
                'og_title' => 'Contact Sparkxe Technologies',
                'og_description' => 'Get a free quote for custom software and AI SEO services.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.8,
            ],
            [
                'route_key' => 'pricing',
                'url_slug' => '/pricing',
                'page_label' => 'Pricing',
                'meta_title' => 'Pricing Plans — Sparkxe Technologies',
                'meta_description' => 'Flexible Sparkxe Technologies pricing for websites, e-commerce, AI SEO, marketing, and enterprise software projects.',
                'meta_keywords' => 'sparkxe technologies pricing, website packages, ai seo pricing',
                'focus_keyword' => 'sparkxe technologies pricing',
                'h1_heading' => 'Flexible packages for every business stage',
                'og_title' => 'Pricing — Sparkxe Technologies',
                'og_description' => 'Flexible packages for software and digital growth.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'faq',
                'url_slug' => '/faq',
                'page_label' => 'FAQ',
                'meta_title' => 'FAQ — Sparkxe Technologies',
                'meta_description' => 'Frequently asked questions about Sparkxe Technologies services, AI SEO (AEO / GEO), timelines, support, and pricing.',
                'meta_keywords' => 'sparkxe technologies faq, ai seo faq, aeo geo questions',
                'focus_keyword' => 'sparkxe technologies faq',
                'h1_heading' => 'Answers to questions we hear often',
                'og_title' => 'FAQ — Sparkxe Technologies',
                'og_description' => 'Answers about Sparkxe Technologies services and AI SEO.',
                'og_image' => $ogImage,
                'schema_type' => 'FAQPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'portfolio',
                'url_slug' => '/portfolio',
                'page_label' => 'Portfolio',
                'meta_title' => 'Portfolio — Sparkxe Technologies',
                'meta_description' => 'Recent Sparkxe Technologies projects — e-commerce, POS, mobile apps, ERP, marketing, and websites.',
                'meta_keywords' => 'sparkxe technologies portfolio, sparkxe.com projects',
                'focus_keyword' => 'sparkxe technologies portfolio',
                'h1_heading' => "Recent work we're proud of",
                'og_title' => 'Portfolio — Sparkxe Technologies',
                'og_description' => 'Selected software and digital projects from Sparkxe Technologies.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'blog',
                'url_slug' => '/blog',
                'page_label' => 'Blog',
                'meta_title' => 'Blog — Sparkxe Technologies',
                'meta_description' => 'Tips and trends from Sparkxe Technologies on AI SEO, AEO, GEO, marketing, software, and design.',
                'meta_keywords' => 'sparkxe technologies blog, ai seo tips, aeo geo insights',
                'focus_keyword' => 'sparkxe technologies blog',
                'h1_heading' => 'Tips and trends from the Sparkxe team',
                'og_title' => 'Blog — Sparkxe Technologies',
                'og_description' => 'AI SEO, AEO, GEO, and software insights from Sparkxe Technologies.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.6,
            ],
            [
                'route_key' => 'privacy',
                'url_slug' => '/privacy-policy',
                'page_label' => 'Privacy Policy',
                'meta_title' => 'Privacy Policy — Sparkxe Technologies',
                'meta_description' => 'Privacy Policy for Sparkxe Technologies (sparkxe.com) — how we collect, use, store, and protect personal information.',
                'meta_keywords' => 'sparkxe technologies privacy policy, sparkxe.com privacy',
                'focus_keyword' => 'sparkxe technologies privacy policy',
                'h1_heading' => 'Privacy Policy',
                'og_title' => 'Privacy Policy — Sparkxe Technologies',
                'og_description' => 'How Sparkxe Technologies protects your personal information.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.4,
            ],
            [
                'route_key' => 'cookies',
                'url_slug' => '/cookie-policy',
                'page_label' => 'Cookie Policy',
                'meta_title' => 'Cookie Policy — Sparkxe Technologies',
                'meta_description' => 'Cookie Policy for Sparkxe Technologies (sparkxe.com) — essential, preference, and analytics cookies explained.',
                'meta_keywords' => 'sparkxe technologies cookie policy, sparkxe.com cookies',
                'focus_keyword' => 'sparkxe technologies cookie policy',
                'h1_heading' => 'Cookie Policy',
                'og_title' => 'Cookie Policy — Sparkxe Technologies',
                'og_description' => 'How Sparkxe Technologies uses cookies on sparkxe.com.',
                'og_image' => $ogImage,
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.4,
            ],
        ];

        foreach ($pages as $page) {
            SeoMeta::query()->updateOrCreate(
                ['route_key' => $page['route_key']],
                $page
            );
        }

        foreach (config('website.services', []) as $service) {
            SeoMeta::query()->updateOrCreate(
                ['route_key' => 'service:'.$service['slug']],
                [
                    'url_slug' => '/services/'.$service['slug'],
                    'page_label' => $service['title'],
                    'meta_title' => $service['title'].' — '.$company,
                    'meta_description' => $service['description'].' By Sparkxe Technologies on sparkxe.com — including AI SEO, AEO, and GEO readiness.',
                    'meta_keywords' => 'sparkxe technologies, sparkxe.com, '.$service['slug'].', '.$service['subtitle'].', ai seo, aeo, geo',
                    'focus_keyword' => strtolower($service['title']),
                    'h1_heading' => $service['title'],
                    'og_title' => $service['title'].' — '.$company,
                    'og_description' => $service['description'],
                    'og_image' => $ogImage,
                    'schema_type' => 'WebPage',
                    'sitemap_priority' => 0.7,
                ]
            );
        }
    }
}
