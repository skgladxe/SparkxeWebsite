<?php

namespace Database\Seeders;

use App\Models\SeoMeta;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'route_key' => 'home',
                'url_slug' => '/new-website',
                'page_label' => 'Home',
                'meta_title' => 'Sparkxe — Digital Solutions Company',
                'meta_description' => 'Sparkxe delivers digital marketing, custom software, mobile apps, e-commerce, ERP, and full-stack digital solutions for modern businesses.',
                'meta_keywords' => 'sparkxe, digital marketing, custom software, mobile apps, web development',
                'focus_keyword' => 'sparkxe digital solutions',
                'h1_heading' => 'Smart Software for Seamless Business Growth',
                'schema_type' => 'Organization',
                'sitemap_priority' => 1.0,
            ],
            [
                'route_key' => 'about',
                'url_slug' => '/new-website/about',
                'page_label' => 'About Us',
                'meta_title' => 'About Sparkxe — Your Digital Growth Partner',
                'meta_description' => 'Learn about Sparkxe — a full-service digital company for marketing, software, web, and design.',
                'meta_keywords' => 'about sparkxe, digital agency, software company',
                'focus_keyword' => 'about sparkxe',
                'h1_heading' => 'Your partner for end-to-end growth',
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.8,
            ],
            [
                'route_key' => 'team',
                'url_slug' => '/new-website/team',
                'page_label' => 'Our Team',
                'meta_title' => 'Our Team — Sparkxe',
                'meta_description' => 'Meet the Sparkxe team — developers, designers, and marketers helping businesses grow online.',
                'meta_keywords' => 'sparkxe team, digital agency team',
                'focus_keyword' => 'sparkxe team',
                'h1_heading' => 'Experts behind Sparkxe',
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'services',
                'url_slug' => '/new-website/services',
                'page_label' => 'All Services',
                'meta_title' => 'Our Services — Sparkxe',
                'meta_description' => 'Explore all Sparkxe services — digital marketing, POS, ERP, mobile apps, e-commerce, design, hosting, and more.',
                'meta_keywords' => 'sparkxe services, digital marketing, pos software, erp',
                'focus_keyword' => 'sparkxe services',
                'h1_heading' => 'Everything your business needs to win online',
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.9,
            ],
            [
                'route_key' => 'contact',
                'url_slug' => '/new-website/contact',
                'page_label' => 'Contact Us',
                'meta_title' => 'Contact Sparkxe — Get a Free Quote',
                'meta_description' => 'Contact Sparkxe for web development, software, marketing, and design projects. Free consultation within 24 hours.',
                'meta_keywords' => 'contact sparkxe, get quote, digital agency contact',
                'focus_keyword' => 'contact sparkxe',
                'h1_heading' => "Let's discuss your next project",
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.8,
            ],
            [
                'route_key' => 'pricing',
                'url_slug' => '/new-website/pricing',
                'page_label' => 'Pricing',
                'meta_title' => 'Pricing Plans — Sparkxe',
                'meta_description' => 'Flexible Sparkxe pricing for websites, e-commerce, marketing, and enterprise software projects.',
                'meta_keywords' => 'sparkxe pricing, website packages, software pricing',
                'focus_keyword' => 'sparkxe pricing',
                'h1_heading' => 'Flexible packages for every business stage',
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'faq',
                'url_slug' => '/new-website/faq',
                'page_label' => 'FAQ',
                'meta_title' => 'FAQ — Sparkxe',
                'meta_description' => 'Frequently asked questions about Sparkxe services, timelines, support, and pricing.',
                'meta_keywords' => 'sparkxe faq, digital agency questions',
                'focus_keyword' => 'sparkxe faq',
                'h1_heading' => 'Answers to questions we hear often',
                'schema_type' => 'FAQPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'portfolio',
                'url_slug' => '/new-website/portfolio',
                'page_label' => 'Portfolio',
                'meta_title' => 'Portfolio — Sparkxe',
                'meta_description' => 'Recent Sparkxe projects — e-commerce, POS, mobile apps, ERP, marketing, and websites.',
                'meta_keywords' => 'sparkxe portfolio, web projects, software projects',
                'focus_keyword' => 'sparkxe portfolio',
                'h1_heading' => "Recent work we're proud of",
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.7,
            ],
            [
                'route_key' => 'blog',
                'url_slug' => '/new-website/blog',
                'page_label' => 'Blog',
                'meta_title' => 'Blog — Sparkxe',
                'meta_description' => 'Tips and trends from the Sparkxe team on marketing, software, and design.',
                'meta_keywords' => 'sparkxe blog, digital marketing tips, software insights',
                'focus_keyword' => 'sparkxe blog',
                'h1_heading' => 'Tips and trends from the Sparkxe team',
                'schema_type' => 'WebPage',
                'sitemap_priority' => 0.6,
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
                    'url_slug' => '/new-website/services/'.$service['slug'],
                    'page_label' => $service['title'],
                    'meta_title' => $service['title'].' — Sparkxe',
                    'meta_description' => $service['description'],
                    'meta_keywords' => 'sparkxe, '.$service['slug'].', '.$service['subtitle'],
                    'focus_keyword' => strtolower($service['title']),
                    'h1_heading' => $service['title'],
                    'schema_type' => 'WebPage',
                    'sitemap_priority' => 0.7,
                ]
            );
        }
    }
}
