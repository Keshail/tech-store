@extends('layouts.app')

@section('title', 'Оформление заказа — TechStore')

@section('content')
    <h1 class="page-title">Оформление заказа</h1>

    <div class="checkout-layout">
        <form class="checkout-form" method="post" action="{{ route('checkout.store') }}">
            @csrf

            <div class="field">
                <label for="customer_name">Имя и фамилия</label>
                <input id="customer_name" type="text" name="customer_name"
                       value="{{ old('customer_name') }}" required maxlength="120">
                @error('customer_name') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="190">
                @error('email') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="phone">Телефон</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                       placeholder="+7 900 000-00-00" required maxlength="32">
                @error('phone') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="address">Адрес доставки</label>
                <input id="address" type="text" name="address" value="{{ old('address') }}" required maxlength="255">
                @error('address') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="comment">Комментарий к заказу</label>
                <textarea id="comment" name="comment" rows="3" maxlength="1000">{{ old('comment') }}</textarea>
                @error('comment') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <button class="btn btn-lg" type="submit">Подтвердить заказ</button>
        </form>

        <aside class="order-summary">
            <h2>Ваш заказ</h2>

            <ul class="summary-list">
                @foreach($items as $item)
                    <li>
                        <span class="summary-list__name">
                            {{ $item['product']->name }}
                            <span class="muted">× {{ $item['quantity'] }}</span>
                        </span>
                        <span class="nowrap">{{ number_format($item['sum'], 0, ',', ' ') }} ₽</span>
                    </li>
                @endforeach
            </ul>

            <div class="summary-total">
                <span>Итого</span>
                <strong>{{ number_format($total, 0, ',', ' ') }} ₽</strong>
            </div>
        </aside>
    </div>
@endsection
