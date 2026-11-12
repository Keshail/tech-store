@extends('admin.layout')

@section('title', 'Товары')
@section('crumb', 'Товары')
@section('heading', 'Товары')

@section('actions')
    <a class="btn" href="{{ route('admin.products.create') }}">+ Добавить товар</a>
@endsection

@section('content')
    <form class="admin-filter" method="get" action="{{ route('admin.products.index') }}">
        <input type="search" name="q" value="{{ $search }}" placeholder="Поиск по названию или бренду">
        <button class="btn btn-ghost" type="submit">Найти</button>
        @if($search !== '')
            <a class="btn btn-ghost" href="{{ route('admin.products.index') }}">Сбросить</a>
        @endif
    </form>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
            <th>Склад</th>
            <th>Хит</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>
                    <img class="thumb" src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                </td>
                <td>
                    <strong>{{ $product->name }}</strong><br>
                    <span class="muted">{{ $product->brand }}</span>
                </td>
                <td>{{ $product->category->name }}</td>
                <td class="nowrap">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->is_featured ? 'да' : '—' }}</td>
                <td class="actions-cell">
                    <a class="btn btn-sm btn-ghost" href="{{ route('admin.products.edit', $product) }}">Изменить</a>
                    <form method="post" action="{{ route('admin.products.destroy', $product) }}"
                          onsubmit="return confirm('Удалить товар «{{ $product->name }}»?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted">Товаров не найдено.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination">{{ $products->links('partials.pagination') }}</div>
@endsection
