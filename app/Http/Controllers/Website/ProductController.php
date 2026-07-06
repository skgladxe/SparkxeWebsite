<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::query()->active()->where('slug', $slug)->firstOrFail();

        return view('website.pages.products.show', [
            'product' => $product,
            'relatedProducts' => Product::query()
                ->active()
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get(),
        ]);
    }
}
