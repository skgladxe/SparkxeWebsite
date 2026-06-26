<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use App\Services\SeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $seoPages = SeoMeta::query()->orderBy('page_label')->get();

        return view('webadmin.seo.index', compact('seoPages'));
    }

    public function create(): View
    {
        return view('webadmin.seo.create', [
            'routeKeySuggestions' => app(SeoService::class)->routeKeySuggestions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page_label' => ['required', 'string', 'max:150'],
            'route_key' => ['required', 'string', 'max:100', Rule::unique('seo_meta', 'route_key')],
            'url_slug' => ['required', 'string', 'max:500', Rule::unique('seo_meta', 'url_slug')],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'schema_type' => ['required', 'in:none,WebPage,FAQPage,Organization'],
            'sitemap_priority' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        $validated['url_slug'] = app(SeoService::class)->normalizeUrlSlug($validated['url_slug']);
        $validated['robots_index'] = true;
        $validated['robots_follow'] = true;
        $validated['meta_title'] = $validated['meta_title'] ?? ($validated['page_label'].' - '.config('website.name'));

        $seoMeta = SeoMeta::create($validated);

        return redirect()
            ->route('admin.seo.edit', $seoMeta)
            ->with('success', 'SEO page created. Complete the remaining settings below.');
    }

    public function edit(SeoMeta $seoMeta): View
    {
        return view('webadmin.seo.edit', compact('seoMeta'));
    }

    public function update(Request $request, SeoMeta $seoMeta): RedirectResponse
    {
        $validated = $request->validate([
            'url_slug' => ['required', 'string', 'max:500', Rule::unique('seo_meta', 'url_slug')->ignore($seoMeta->id)],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'focus_keyword' => ['nullable', 'string', 'max:150'],
            'h1_heading' => ['nullable', 'string', 'max:255'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'robots_index' => ['nullable', 'boolean'],
            'robots_follow' => ['nullable', 'boolean'],
            'schema_type' => ['required', 'in:none,WebPage,FAQPage,Organization'],
            'schema_json' => ['nullable', 'string'],
            'sitemap_priority' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        if (filled($validated['schema_json'] ?? null)) {
            json_decode($validated['schema_json'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors(['schema_json' => 'Schema JSON must be valid JSON.']);
            }
        }

        $validated['robots_index'] = $request->boolean('robots_index');
        $validated['robots_follow'] = $request->boolean('robots_follow');
        $validated['url_slug'] = app(SeoService::class)->normalizeUrlSlug($validated['url_slug']);

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('seo', 'public');
        } else {
            unset($validated['og_image']);
        }

        $seoMeta->update($validated);

        return redirect()
            ->route('admin.seo.index')
            ->with('success', 'SEO settings updated successfully.');
    }

    public function generateSchema(Request $request, SeoMeta $seoMeta, SeoService $seoService): JsonResponse
    {
        $request->validate([
            'schema_type' => ['required', 'in:none,WebPage,FAQPage,Organization'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
        ]);

        $seoMeta->fill([
            'schema_type' => $request->input('schema_type'),
            'meta_title' => $request->input('meta_title', $seoMeta->meta_title),
            'meta_description' => $request->input('meta_description', $seoMeta->meta_description),
            'canonical_url' => $request->input('canonical_url', $seoMeta->canonical_url),
        ]);

        return response()->json([
            'schema_json' => $seoService->buildSchemaJson($seoMeta),
        ]);
    }
}
