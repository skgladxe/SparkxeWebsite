<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Faq;
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
            ['name' => 'Arjun Mehta', 'role' => 'CEO & Founder', 'sort_order' => 1, 'linkedin' => '#'],
            ['name' => 'Priya Sharma', 'role' => 'Lead Developer', 'sort_order' => 2, 'github' => '#'],
            ['name' => 'Michael Chen', 'role' => 'UI/UX Designer', 'sort_order' => 3, 'dribbble' => '#'],
            ['name' => 'Sara Johnson', 'role' => 'Marketing Head', 'sort_order' => 4, 'instagram' => '#'],
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
    }
}
