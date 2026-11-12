@extends('layouts.app')

@section('title', 'TechStore — магазин техники')

@section('content')
    <section class="hero">
        <div class="hero__text">
            <h1>Техника для работы, учёбы и игр</h1>
            <p>Ноутбуки, смартфоны, комплектующие и периферия — с доставкой по России.</p>
            <a class="btn btn-lg" href="{{ route('catalog.index') }}">Перейти в каталог</a>
        </div>
        <div class="hero__art" aria-hidden="true">
            <div class="hero__circle"></div>
            <div class="hero__laptop">
                <div class="hero__screen"></div>
                <div class="hero__base"></div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__head">
            <h2>Категории</h2>
        </div>
        <div class="category-grid">
            @foreach($categories as $category)
                <a class="category-card" href="{{ route('catalog.index', ['category' => $category->slug]) }}">
                    <span class="category-card__name">{{ $category->name }}</span>
                    <span class="category-card__count">{{ $category->products_count }} {{ plural_ru($category->products_count, 'товар', 'товара', 'товаров') }}</span>
                </a>
            @endforeach
        </div>
    </section>

    @if($featured->isNotEmpty())
        <section class="section">
            <div class="section__head">
                <h2>Хиты продаж</h2>
                <a class="link-all" href="{{ route('catalog.index') }}">Смотреть все →</a>
            </div>
            <div class="product-grid">
                @foreach($featured as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    @if($latest->isNotEmpty())
        <section class="section">
            <div class="section__head">
                <h2>Новинки</h2>
            </div>
            <div class="product-grid">
                @foreach($latest as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif
@endsection
