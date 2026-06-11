<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['images', 'brand', 'category'])
            ->where('is_active', true);

        $activeCategory = null;

        if ($request->filled('category')) {
            $activeCategory = Category::where('slug', $request->string('category'))->first();

            if ($activeCategory) {
                $categoryIds = $activeCategory->children()->pluck('id')->push($activeCategory->id);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->filled('brands')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->whereIn('slug', (array) $request->input('brands'));
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('shop.index', compact('products', 'categories', 'brands', 'activeCategory'));
    }
}
