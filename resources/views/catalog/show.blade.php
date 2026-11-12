@extends('layouts.app')

@section('title', $product->name . ' — TechStore')

@section('content')
    <nav class="breadcrumbs">
        <a href="{{ route('home') }}">Главная</a>
        <span>/</span>
        <a href="{{ route('catalog.index') }}">Каталог</a>
        <span>/</span>
        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="current">{{ $product->name }}</span>
    </nav>

    <div class="product-detail">
        <div class="product-detail__media">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
        </div>

        <div class="product-detail__info">
            <span class="product-detail__brand">{{ $product->brand }}</span>
            <h1>{{ $product->name }}</h1>

            <div class="product-detail__price">
                {{ number_format((float) $product->price, 0, ',', ' ') }} ₽
            </div>

            <p class="product-detail__stock">
                @if($product->stock > 0)
                    <span class="in-stock">В наличии: {{ $product->stock }} шт.</span>
                @else
                    <span class="out-stock">Нет в наличии</span>
                @endif
            </p>

            @if($product->stock > 0)
                <form class="add-to-cart" method="post" action="{{ route('cart.add', $product) }}">
                    @csrf
                    <label for="quantity">Количество</label>
                    <input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                    <button class="btn btn-lg" type="submit">Добавить в корзину</button>
                </form>
            @endif

            @if($product->description)
                <div class="product-detail__description">
                    <h2>Описание</h2>
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            <dl class="product-specs">
                <dt>Категория</dt>
                <dd>
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">
                        {{ $product->category->name }}
                    </a>
                </dd>
                <dt>Бренд</dt>
                <dd>{{ $product->brand ?: '—' }}</dd>
                <dt>Артикул</dt>
                <dd>TS-{{ str_pad((string) $product->id, 4, '0', STR_PAD_LEFT) }}</dd>
            </dl>
        </div>
    </div>

    @if($related->isNotEmpty())
        <section class="section">
            <div class="section__head">
                <h2>Похожие товары</h2>
            </div>
            <div class="product-grid">
                @foreach($related as $relatedProduct)
                    @include('partials.product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
    @endif
@endsection
