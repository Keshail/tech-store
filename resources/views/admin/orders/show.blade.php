@extends('admin.layout')

@section('title', 'Заказ №' . $order->id)
@section('crumb', 'Заказ №' . $order->id)
@section('heading', 'Заказ №' . $order->id)

@section('actions')
    <a class="btn btn-ghost" href="{{ route('admin.orders.index') }}">← К списку</a>
@endsection

@section('content')
    <div class="admin-columns">
        <section class="panel">
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
        </section>

        <section class="panel">
            <h2>Клиент</h2>
            <dl class="product-specs">
                <dt>Имя</dt>
                <dd>{{ $order->customer_name }}</dd>
                <dt>E-mail</dt>
                <dd>{{ $order->email }}</dd>
                <dt>Телефон</dt>
                <dd>{{ $order->phone }}</dd>
                <dt>Адрес</dt>
                <dd>{{ $order->address }}</dd>
                <dt>Комментарий</dt>
                <dd>{{ $order->comment ?: '—' }}</dd>
                <dt>Создан</dt>
                <dd>{{ $order->created_at->format('d.m.Y H:i') }}</dd>
            </dl>

            <h2>Статус</h2>
            <form class="status-form" method="post" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                @method('PATCH')

                <select name="status">
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                    @endforeach
                </select>

                <button class="btn btn-sm" type="submit">Сохранить</button>
            </form>
        </section>
    </div>
@endsection
