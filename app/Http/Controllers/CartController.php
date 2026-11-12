<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly Cart $cart)
    {
    }

    public function index(): View
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($product->stock < 1) {
            return back()->with('error', 'Товара нет в наличии');
        }

        $this->cart->add($product->id, min($quantity, $product->stock));

        return back()->with('success', "«{$product->name}» добавлен в корзину");
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->cart->update($product->id, (int) $request->input('quantity', 0));

        return redirect()->route('cart.index')->with('success', 'Корзина обновлена');
    }

    public function remove(Product $product): RedirectResponse
    {
        $this->cart->remove($product->id);

        return redirect()->route('cart.index')->with('success', 'Товар удалён из корзины');
    }

    public function clear(): RedirectResponse
    {
        $this->cart->clear();

        return redirect()->route('cart.index')->with('success', 'Корзина очищена');
    }
}
