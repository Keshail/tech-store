<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products'   => Product::count(),
            'categories' => Category::count(),
            'orders'     => Order::count(),
            'newOrders'  => Order::where('status', 'new')->count(),
            'revenue'    => (float) Order::whereIn('status', ['paid', 'shipped', 'done'])->sum('total'),
        ];

        $latestOrders = Order::orderByDesc('id')->limit(8)->get();

        $lowStock = Product::where('stock', '<', 5)->orderBy('stock')->limit(6)->get();

        return view('admin.dashboard', compact('stats', 'latestOrders', 'lowStock'));
    }
}
