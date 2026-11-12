<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Корзина в сессии: [product_id => quantity].
 */
class Cart
{
    private const KEY = 'cart';

    /** @return array<int, int> */
    public function raw(): array
    {
        return session()->get(self::KEY, []);
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->raw();
        $cart[$productId] = ($cart[$productId] ?? 0) + max(1, $quantity);

        session()->put(self::KEY, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->raw();

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put(self::KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->raw();
        unset($cart[$productId]);

        session()->put(self::KEY, $cart);
    }

    public function clear(): void
    {
        session()->forget(self::KEY);
    }

    /**
     * Позиции корзины с товарами.
     *
     * @return Collection<int, array{product: Product, quantity: int, sum: float}>
     */
    public function items(): Collection
    {
        $cart = $this->raw();

        if ($cart === []) {
            return collect();
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        return collect($cart)
            ->filter(fn (int $qty, int $id): bool => $products->has($id))
            ->map(fn (int $qty, int $id): array => [
                'product'  => $products[$id],
                'quantity' => $qty,
                'sum'      => (float) $products[$id]->price * $qty,
            ])
            ->values();
    }

    public function total(): float
    {
        return (float) $this->items()->sum('sum');
    }

    public function count(): int
    {
        return (int) array_sum($this->raw());
    }
}
