<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $featuredProducts = Product::query()
            ->with(['images', 'brand'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newArrivals = Product::query()
            ->with(['images', 'brand'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredCategories', 'featuredProducts', 'newArrivals'));
    }
}
