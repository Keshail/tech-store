<article class="product-card">
    <a class="product-card__image" href="{{ route('catalog.show', $product) }}">
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
        @if($product->is_featured)
            <span class="badge badge-hit">Хит</span>
        @endif
        @if($product->stock < 1)
            <span class="badge badge-out">Нет в наличии</span>
        @endif
    </a>

    <div class="product-card__body">
        <span class="product-card__brand">{{ $product->brand }}</span>
        <h3 class="product-card__title">
            <a href="{{ route('catalog.show', $product) }}">{{ $product->name }}</a>
        </h3>
        <p class="product-card__category">{{ $product->category->name }}</p>

        <div class="product-card__footer">
            <span class="price">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</span>

            @if($product->stock > 0)
                <form method="post" action="{{ route('cart.add', $product) }}">
                    @csrf
                    <button class="btn btn-sm" type="submit">В корзину</button>
                </form>
            @else
                <span class="muted">нет в наличии</span>
            @endif
        </div>
    </div>
</article>
