<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        return view('webadmin.blog-categories.index', [
            'categories' => BlogCategory::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('webadmin.blog-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategory($request);
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['name']);

        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category created.');
    }

    public function edit(BlogCategory $blogCategory): View
    {
        return view('webadmin.blog-categories.edit', ['category' => $blogCategory]);
    }

    public function update(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        $validated = $this->validateCategory($request, $blogCategory->id);
        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?? $validated['name'],
            $blogCategory->id
        );

        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category deleted.');
    }

    private function validateCategory(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150', Rule::unique('blog_categories', 'slug')->ignore($ignoreId)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) ($request->input('sort_order', 0)),
        ];
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source);
        $base = $slug;
        $i = 1;

        while (BlogCategory::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
