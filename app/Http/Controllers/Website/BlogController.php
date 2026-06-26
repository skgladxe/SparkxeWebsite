<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('website.pages.blog', [
            'blogs' => Blog::query()->published()->with('category')->latest('published_at')->get(),
            'categories' => BlogCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $blog = Blog::query()->published()->with('category')->where('slug', $slug)->firstOrFail();

        return view('website.pages.blog-show', [
            'blog' => $blog,
            'relatedBlogs' => Blog::query()
                ->published()
                ->where('id', '!=', $blog->id)
                ->when($blog->blog_category_id, fn ($q) => $q->where('blog_category_id', $blog->blog_category_id))
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
