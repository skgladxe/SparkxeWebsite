<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\SeoMeta;
use App\Services\SeoService;
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

    public function store(Request $request, SeoService $seoService): RedirectResponse
    {
        $validated = $this->validateBlog($request);
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title']);
        $seoData = $this->validateSeo($request);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $blog = Blog::create($validated);
        $this->syncSeo($blog, $seoData, $seoService);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created.');
    }

    public function edit(Blog $blog): View
    {
        return view('webadmin.blogs.edit', [
            'blog' => $blog,
            'seoMeta' => $blog->seoMeta(),
            'categories' => BlogCategory::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Blog $blog, SeoService $seoService): RedirectResponse
    {
        $previousSlug = $blog->slug;
        $validated = $this->validateBlog($request, $blog->id);
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title'], $blog->id);
        $seoData = $this->validateSeo($request);

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
        $this->syncSeo($blog->fresh(), $seoData, $seoService, $previousSlug);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->deleteStoredImage($blog->featured_image);
        SeoMeta::query()
            ->where(function ($query) use ($blog) {
                $query->where('route_key', $blog->seoRouteKey())
                    ->orWhere('url_slug', $blog->seoUrlSlug());
            })
            ->delete();
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

    private function validateSeo(Request $request): array
    {
        $validated = $request->validate([
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'focus_keyword' => ['nullable', 'string', 'max:150'],
            'h1_heading' => ['nullable', 'string', 'max:255'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'robots_index' => ['nullable', 'boolean'],
            'robots_follow' => ['nullable', 'boolean'],
            'schema_type' => ['nullable', 'in:none,WebPage,Article'],
            'schema_json' => ['nullable', 'string'],
            'sitemap_priority' => ['nullable', 'numeric', 'min:0', 'max:1'],
        ]);

        if (filled($validated['schema_json'] ?? null)) {
            json_decode($validated['schema_json'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'schema_json' => 'Schema JSON must be valid JSON.',
                ]);
            }
        }

        $validated['robots_index'] = $request->boolean('robots_index');
        $validated['robots_follow'] = $request->boolean('robots_follow');
        $validated['schema_type'] = $validated['schema_type'] ?? 'Article';
        $validated['sitemap_priority'] = $validated['sitemap_priority'] ?? '0.7';

        return $validated;
    }

    private function syncSeo(Blog $blog, array $seoData, SeoService $seoService, ?string $previousSlug = null): void
    {
        $routeKey = $blog->seoRouteKey();
        $urlSlug = $seoService->normalizeUrlSlug($blog->seoUrlSlug());
        $company = config('website.name', 'Sparkxe Technologies');

        $seo = null;
        if ($previousSlug) {
            $seo = $blog->seoMeta($previousSlug);
        }
        $seo ??= $blog->seoMeta();

        $payload = [
            'route_key' => $routeKey,
            'url_slug' => $urlSlug,
            'page_label' => $blog->title,
            'meta_title' => $seoData['meta_title'] ?: ($blog->title.' — '.$company),
            'meta_description' => $seoData['meta_description'] ?: $blog->excerpt,
            'meta_keywords' => $seoData['meta_keywords'] ?? null,
            'focus_keyword' => $seoData['focus_keyword'] ?? null,
            'h1_heading' => $seoData['h1_heading'] ?: $blog->title,
            'og_title' => $seoData['og_title'] ?? null,
            'og_description' => $seoData['og_description'] ?? null,
            'canonical_url' => $seoData['canonical_url'] ?: $seoService->publicUrl($urlSlug),
            'robots_index' => $seoData['robots_index'],
            'robots_follow' => $seoData['robots_follow'],
            'schema_type' => $seoData['schema_type'],
            'schema_json' => $seoData['schema_json'] ?? null,
            'sitemap_priority' => $seoData['sitemap_priority'],
        ];

        if ($seo) {
            $seo->update($payload);
        } else {
            SeoMeta::create($payload);
        }
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
