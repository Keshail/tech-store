@extends('layouts.app')

@section('title', 'Каталог — TechStore')

@section('content')
    <h1 class="page-title">Каталог техники</h1>

    <div class="catalog-layout">
        <aside class="filters">
            <form method="get" action="{{ route('catalog.index') }}">
                <div class="field">
                    <label for="category">Категория</label>
                    <select id="category" name="category">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}"
                                @selected($filters['category'] === $category->slug)>
                                {{ $category->name }} ({{ $category->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="q">Поиск</label>
                    <input id="q" type="search" name="q" value="{{ $filters['q'] }}" placeholder="Например, ноутбук">
                </div>

                <div class="field field-row">
                    <div>
                        <label for="min">Цена от</label>
                        <input id="min" type="number" name="min" min="0" step="100"
                               value="{{ $filters['min'] }}" placeholder="{{ $priceRange['min'] }}">
                    </div>
                    <div>
                        <label for="max">до</label>
                        <input id="max" type="number" name="max" min="0" step="100"
                               value="{{ $filters['max'] }}" placeholder="{{ $priceRange['max'] }}">
                    </div>
                </div>

                <div class="field">
                    <label for="sort">Сортировка</label>
                    <select id="sort" name="sort">
                        <option value="" @selected($filters['sort'] === null)>По популярности</option>
                        <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Сначала дешёвые</option>
                        <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Сначала дорогие</option>
                        <option value="name" @selected($filters['sort'] === 'name')>По названию</option>
                        <option value="new" @selected($filters['sort'] === 'new')>Сначала новые</option>
                    </select>
                </div>

                <div class="filters__actions">
                    <button class="btn" type="submit">Применить</button>
                    <a class="btn btn-ghost" href="{{ route('catalog.index') }}">Сбросить</a>
                </div>
            </form>
        </aside>

        <section class="catalog-results">
            <p class="muted">
                Найдено {{ $products->total() }} {{ plural_ru($products->total(), 'товар', 'товара', 'товаров') }}
            </p>

            @if($products->isEmpty())
                <div class="empty">
                    <p>По вашему запросу ничего не нашлось.</p>
                    <a class="btn btn-ghost" href="{{ route('catalog.index') }}">Сбросить фильтры</a>
                </div>
            @else
                <div class="product-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="pagination">
                    {{ $products->links('partials.pagination') }}
                </div>
            @endif
        </section>
    </div>
@endsection
