@extends('admin.layout')

@section('title', 'Дашборд')
@section('crumb', 'Дашборд')
@section('heading', 'Дашборд')
@section('subtitle', 'Сводка по магазину на ' . now()->format('d.m.Y, H:i'))

@section('content')
    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-card__top">
                <span class="stat-card__icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2 3 6.5v11L12 22l9-4.5v-11L12 2Zm0 2.3 6.3 3.2L12 10.7 5.7 7.5 12 4.3ZM5 9.2l6 3v7.4l-6-3V9.2Zm8 10.4v-7.4l6-3v7.4l-6 3Z"/></svg>
                </span>
                Товары
            </span>
            <span class="stat-card__value">{{ $stats['products'] }}</span>
            <span class="stat-card__label">в каталоге</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__top">
                <span class="stat-card__icon">
                    <svg viewBox="0 0 24 24"><path d="M12 3 2 8l10 5 10-5-10-5Zm-8.6 7.4L12 14.6l8.6-4.2 1.4.7-10 4.9-10-4.9 1.4-.7Z"/></svg>
                </span>
                Категории
            </span>
            <span class="stat-card__value">{{ $stats['categories'] }}</span>
            <span class="stat-card__label">разделов каталога</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__top">
                <span class="stat-card__icon">
                    <svg viewBox="0 0 24 24"><path d="M6 2h9l5 5v15H6V2Zm2 2v16h10V8h-4V4H8Z"/></svg>
                </span>
                Заказы
            </span>
            <span class="stat-card__value">{{ $stats['orders'] }}</span>
            <span class="stat-card__label">за всё время</span>
        </div>

        <div class="stat-card stat-card--accent">
            <span class="stat-card__top">
                <span class="stat-card__icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7v4l-2 4h18l-2-4V9a7 7 0 0 0-7-7Zm0 20a3 3 0 0 0 3-3H9a3 3 0 0 0 3 3Z"/></svg>
                </span>
                Новые
            </span>
            <span class="stat-card__value">{{ $stats['newOrders'] }}</span>
            <span class="stat-card__label">требуют обработки</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__top">
                <span class="stat-card__icon">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16v16H4V4Zm2 2v12h12V6H6Zm2 8h4v2H8v-2Zm0-4h8v2H8v-2Zm0-4h8v2H8V6Z"/></svg>
                </span>
                Оплачено
            </span>
            <span class="stat-card__value">{{ number_format($stats['revenue'], 0, ',', ' ') }} ₽</span>
            <span class="stat-card__label">по завершённым заказам</span>
        </div>
    </div>

    <div class="admin-columns">
        <section class="panel">
            <div class="panel__head">
                <h2>Последние заказы</h2>
                <a href="{{ route('admin.orders.index') }}">Все заказы →</a>
            </div>

            @if($latestOrders->isEmpty())
                <div class="panel__body">
                    <p class="muted">Заказов ещё нет. Они появятся здесь после оформления на витрине.</p>
                </div>
            @else
                <div class="panel__body panel__body--flush">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($latestOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}">№{{ $order->id }}</a></td>
                                <td>
                                    {{ $order->customer_name }}
                                    <div class="muted">{{ $order->created_at->format('d.m H:i') }}</div>
                                </td>
                                <td class="nowrap">{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td>
                                <td><span class="status status-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="panel">
            <div class="panel__head">
                <h2>Заканчивается на складе</h2>
                <a href="{{ route('admin.products.index') }}">К товарам →</a>
            </div>

            <div class="panel__body">
                @if($lowStock->isEmpty())
                    <p class="muted">Все товары в достатке.</p>
                @else
                    <ul class="plain-list">
                        @foreach($lowStock as $product)
                            <li>
                                <a href="{{ route('admin.products.edit', $product) }}">{{ $product->name }}</a>
                                <span class="muted">— осталось {{ $product->stock }} шт.</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    </div>
@endsection
