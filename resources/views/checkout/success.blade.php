@extends('layouts.app')

@section('title', 'Заказ №' . $order->id . ' — TechStore')

@section('content')
    <div class="success-box">
        <div class="success-icon" aria-hidden="true">✓</div>
        <h1>Заказ №{{ $order->id }} оформлен</h1>
        <p class="muted">
            Мы отправили детали на {{ $order->email }}. Статус заказа:
            <strong>{{ $order->statusLabel() }}</strong>.
        </p>
    </div>

    <div class="order-card">
        <h2>Состав заказа</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="nowrap">{{ number_format((float) $item->price, 0, ',', ' ') }} ₽</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="nowrap">{{ number_format($item->sum(), 0, ',', ' ') }} ₽</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="align-right">Итого:</td>
                <td class="nowrap total">{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td>
            </tr>
            </tfoot>
        </table>

        <h2>Доставка</h2>
        <p>
            {{ $order->customer_name }}<br>
            {{ $order->phone }}<br>
            {{ $order->address }}
        </p>

        @if($order->comment)
            <p class="muted">Комментарий: {{ $order->comment }}</p>
        @endif
    </div>

    <div class="cart-actions">
        <a class="btn" href="{{ route('catalog.index') }}">Вернуться в каталог</a>
        <a class="btn btn-ghost" href="{{ route('home') }}">На главную</a>
    </div>
@endsection
