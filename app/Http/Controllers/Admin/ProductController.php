<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('webadmin.products.index', [
            'products' => Product::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('webadmin.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        foreach (['image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('products', 'public');
            }
        }

        if (blank($validated['slug'] ?? null)) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('webadmin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);

        foreach (['image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('products', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,'.($product?->id ?? 'NULL')],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($request->input('sort_order', 0)),
        ];
    }
}
