@extends('admin.layout')

@section('title', 'Заказы')
@section('crumb', 'Заказы')
@section('heading', 'Заказы')

@section('content')
    <form class="admin-filter" method="get" action="{{ route('admin.orders.index') }}">
        <select name="status" onchange="this.form.submit()">
            <option value="">Все статусы</option>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <noscript><button class="btn btn-ghost" type="submit">Показать</button></noscript>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>№</th>
            <th>Дата</th>
            <th>Клиент</th>
            <th>Позиций</th>
            <th>Сумма</th>
            <th>Статус</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>№{{ $order->id }}</td>
                <td class="nowrap">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>{{ $order->customer_name }}<br><span class="muted">{{ $order->email }}</span></td>
                <td>{{ $order->items_count }}</td>
                <td class="nowrap">{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td>
                <td><span class="status status-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                <td><a class="btn btn-sm btn-ghost" href="{{ route('admin.orders.show', $order) }}">Открыть</a></td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted">Заказов нет.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination">{{ $orders->links('partials.pagination') }}</div>
@endsection
