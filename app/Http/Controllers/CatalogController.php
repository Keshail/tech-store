<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'category' => $request->string('category')->toString() ?: null,
            'q'        => $request->string('q')->toString() ?: null,
            'min'      => $request->filled('min') ? (float) $request->input('min') : null,
            'max'      => $request->filled('max') ? (float) $request->input('max') : null,
            'sort'     => $request->string('sort')->toString() ?: null,
        ];

        $products = Product::with('category')
            ->filtered($filters)
            ->paginate(9)
            ->withQueryString();

        $categories = Category::withCount('products')->orderBy('name')->get();

        $priceRange = [
            'min' => (int) floor((float) Product::min('price')),
            'max' => (int) ceil((float) Product::max('price')),
        ];

        return view('catalog.index', compact('products', 'categories', 'filters', 'priceRange'));
    }

    public function show(Product $product): View
    {
        $product->load('category');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderByDesc('is_featured')
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'related'));
    }
}
