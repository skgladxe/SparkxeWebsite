<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Marketing', 'slug' => 'marketing', 'sort_order' => 1],
            ['name' => 'Software', 'slug' => 'software', 'sort_order' => 2],
            ['name' => 'Design', 'slug' => 'design', 'sort_order' => 3],
        ];

        foreach ($categories as $cat) {
            BlogCategory::query()->updateOrCreate(['slug' => $cat['slug']], $cat + ['is_active' => true]);
        }

        $marketing = BlogCategory::where('slug', 'marketing')->first();
        $software = BlogCategory::where('slug', 'software')->first();
        $design = BlogCategory::where('slug', 'design')->first();

        $posts = [
            [
                'blog_category_id' => $marketing->id,
                'title' => '5 Digital Marketing Strategies That Actually Work in 2026',
                'slug' => 'digital-marketing-strategies-2026',
                'excerpt' => 'Learn how SEO, social ads, and WhatsApp campaigns can bring real customers to your business.',
                'content' => '<p>Digital marketing in 2026 is about measurable growth — SEO, paid ads, and WhatsApp funnels working together. Sparkxe helps businesses build campaigns that convert.</p>',
                'read_time' => 5,
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
            [
                'blog_category_id' => $software->id,
                'title' => 'When Your Business Needs Custom Software (Not a Template)',
                'slug' => 'when-you-need-custom-software',
                'excerpt' => 'POS, ERP, and bespoke apps save time and money — here\'s how to know when you\'re ready.',
                'content' => '<p>Off-the-shelf tools work until your workflow outgrows them. Custom POS, ERP, and internal apps pay off when manual work costs more than development.</p>',
                'read_time' => 7,
                'is_published' => true,
                'published_at' => now()->subDays(19),
            ],
            [
                'blog_category_id' => $design->id,
                'title' => 'UI/UX Mistakes That Cost You Customers — And How to Fix Them',
                'slug' => 'ui-ux-mistakes-to-fix',
                'excerpt' => 'Simple design improvements that boost trust, usability, and conversion on any website or app.',
                'content' => '<p>Slow load times, confusing navigation, and weak mobile layouts drive users away. Small UX fixes often deliver the biggest conversion gains.</p>',
                'read_time' => 4,
                'is_published' => true,
                'published_at' => now()->subDays(27),
            ],
        ];

        foreach ($posts as $post) {
            Blog::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }

        $team = [
            ['name' => 'Arjun Mehta', 'role' => 'CEO & Founder', 'sort_order' => 1],
            ['name' => 'Priya Sharma', 'role' => 'Lead Developer', 'sort_order' => 2],
            ['name' => 'Michael Chen', 'role' => 'UI/UX Designer', 'sort_order' => 3],
            ['name' => 'Sara Johnson', 'role' => 'Marketing Head', 'sort_order' => 4],
        ];

        foreach ($team as $member) {
            TeamMember::query()->updateOrCreate(
                ['name' => $member['name']],
                $member + ['is_active' => true]
            );
        }

        foreach (config('website.faqs', []) as $i => $faq) {
            Faq::query()->updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'is_active' => true,
                    'is_open_default' => $faq['active'] ?? false,
                    'sort_order' => $i,
                ]
            );
        }

        HeroSlide::query()->updateOrCreate(
            ['subtitle' => 'Innovation That Powers Growth'],
            [
                'title' => "We're Sparkxe, digital solutions for modern businesses",
                'title_highlight' => 'Sparkxe',
                'description' => 'From digital marketing and custom software to mobile apps, e-commerce, and ERP systems — Sparkxe helps businesses launch, scale, and succeed online with strategy, design, and technology under one roof.',
                'primary_button_text' => 'Get Started',
                'primary_button_url' => '/new-website/contact',
                'secondary_button_text' => 'Learn More',
                'secondary_button_url' => '/new-website/services',
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        Product::query()->whereNull('slug')->delete();

        foreach (config('website.specialization_services', []) as $i => $item) {
            Product::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'subtitle' => $item['title'],
                    'description' => $item['description'],
                    'icon' => $item['icon'],
                    'notes' => null,
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }

        foreach (config('website.services', []) as $i => $item) {
            $featuresHtml = collect($item['features'] ?? [])->map(fn ($f) => '<li>'.$f.'</li>')->implode('');
            $notes = filled($featuresHtml) ? '<ul>'.$featuresHtml.'</ul>' : null;

            Service::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'subtitle' => $item['subtitle'] ?? null,
                    'description' => $item['description'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'notes' => $notes,
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }

        SiteSetting::set('theme_mode', 'preset');
        SiteSetting::set('theme_preset', config('website.default_theme'));
        SiteSetting::set('theme_accent_color', '#F0FF6C');
        SiteSetting::set('theme_accent_secondary_color', '#6BFDD9');
        SiteSetting::set('theme_black_color', '#163031');
        SiteSetting::set('theme_primary_color', '#F8F8F8');
        SiteSetting::set('section_hero_visible', '1');
        SiteSetting::set('section_products_visible', '1');
        SiteSetting::set('hide_theme_picker', '0');
        SiteSetting::set('services_section_eyebrow', 'Our Services');
        SiteSetting::set('services_section_title', 'Everything your business needs to win online');
        SiteSetting::set('services_section_title_highlight', 'win online');
    }
}
