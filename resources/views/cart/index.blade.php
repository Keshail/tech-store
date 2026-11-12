@extends('layouts.app')

@section('title', 'Корзина — TechStore')

@section('content')
    <h1 class="page-title">Корзина</h1>

    @if($items->isEmpty())
        <div class="empty">
            <p>Корзина пуста.</p>
            <a class="btn" href="{{ route('catalog.index') }}">Перейти в каталог</a>
        </div>
    @else
        <table class="table cart-table">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>
                        <div class="cart-product">
                            <img src="{{ $item['product']->imageUrl() }}" alt="{{ $item['product']->name }}" width="64" height="64">
                            <a href="{{ route('catalog.show', $item['product']) }}">{{ $item['product']->name }}</a>
                        </div>
                    </td>
                    <td class="nowrap">{{ number_format((float) $item['product']->price, 0, ',', ' ') }} ₽</td>
                    <td>
                        <form class="qty-form" method="post" action="{{ route('cart.update', $item['product']) }}">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                   min="0" max="{{ $item['product']->stock }}">
                            <button class="btn btn-sm btn-ghost" type="submit">Обновить</button>
                        </form>
                    </td>
                    <td class="nowrap">{{ number_format($item['sum'], 0, ',', ' ') }} ₽</td>
                    <td>
                        <form method="post" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="align-right">Итого:</td>
                <td class="nowrap total">{{ number_format($total, 0, ',', ' ') }} ₽</td>
                <td></td>
            </tr>
            </tfoot>
        </table>

        <div class="cart-actions">
            <a class="btn" href="{{ route('checkout.index') }}">Оформить заказ</a>
            <a class="btn btn-ghost" href="{{ route('catalog.index') }}">Продолжить покупки</a>
            <form method="post" action="{{ route('cart.clear') }}" class="inline-form">
                @csrf
                <button class="btn btn-ghost" type="submit">Очистить корзину</button>
            </form>
        </div>
    @endif
@endsection
