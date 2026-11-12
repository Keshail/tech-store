<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Product::with('category')
            ->where('is_featured', true)
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $latest = Product::with('category')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('home', compact('featured', 'latest', 'categories'));
    }
}
