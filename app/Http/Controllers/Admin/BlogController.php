<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('webadmin.blogs.index', [
            'blogs' => Blog::query()->with('category')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('webadmin.blogs.create', [
            'categories' => BlogCategory::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBlog($request);
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created.');
    }

    public function edit(Blog $blog): View
    {
        return view('webadmin.blogs.edit', [
            'blog' => $blog,
            'categories' => BlogCategory::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $this->validateBlog($request, $blog->id);
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title'], $blog->id);

        if ($request->hasFile('featured_image')) {
            $this->deleteStoredImage($blog->featured_image);
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        } elseif ($request->boolean('remove_featured_image')) {
            $this->deleteStoredImage($blog->featured_image);
            $validated['featured_image'] = null;
        } else {
            unset($validated['featured_image']);
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->deleteStoredImage($blog->featured_image);
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted.');
    }

    private function deleteStoredImage(?string $path): void
    {
        if (filled($path) && ! str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }

    private function validateBlog(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blogs', 'slug')->ignore($ignoreId)],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'read_time' => ['nullable', 'integer', 'min:1', 'max:120'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'read_time' => (int) ($request->input('read_time', 5)),
        ];
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source);
        $base = $slug;
        $i = 1;

        while (Blog::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
