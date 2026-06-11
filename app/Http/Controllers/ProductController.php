<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with(['images', 'variants', 'brand', 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['images', 'brand'])
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $variantsData = $product->variants->map(fn ($variant) => [
            'id' => $variant->id,
            'name' => $variant->name,
            'price' => $variant->price,
            'current_price' => $variant->current_price,
            'stock' => $variant->stock_quantity,
        ])->values();

        $defaultVariantId = $product->variants->firstWhere('is_default', true)?->id
            ?? $product->variants->first()?->id;

        return view('products.show', compact('product', 'relatedProducts', 'variantsData', 'defaultVariantId'));
    }
}
