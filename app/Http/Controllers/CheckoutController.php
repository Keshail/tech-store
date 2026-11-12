<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private readonly Cart $cart)
    {
    }

    public function index(): View|RedirectResponse
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        return view('checkout.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'email'         => ['required', 'email', 'max:190'],
            'phone'         => ['required', 'string', 'max:32'],
            'address'       => ['required', 'string', 'max:255'],
            'comment'       => ['nullable', 'string', 'max:1000'],
        ]);

        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $order = DB::transaction(function () use ($data, $items) {
            $order = Order::create($data + [
                'total'  => $items->sum('sum'),
                'status' => 'new',
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id'   => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price'        => $item['product']->price,
                    'quantity'     => $item['quantity'],
                ]);

                $item['product']->decrement('stock', min($item['quantity'], $item['product']->stock));
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()
            ->route('order.show', $order)
            ->with('success', "Заказ №{$order->id} оформлен");
    }

    public function show(Order $order): View
    {
        $order->load('items');

        return view('checkout.success', compact('order'));
    }
}
