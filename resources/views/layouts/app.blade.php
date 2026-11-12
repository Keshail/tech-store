<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TechStore — магазин техники')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@inject('cart', 'App\Services\Cart')

<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="{{ route('home') }}">
            <span class="logo-mark">TS</span>
            <span class="logo-text">TechStore</span>
        </a>

        <nav class="main-nav">
            <a href="{{ route('catalog.index') }}">Каталог</a>
            @foreach($navCategories as $category)
                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
            @endforeach
        </nav>

        <a class="cart-link" href="{{ route('cart.index') }}">
            Корзина
            @if($cart->count() > 0)
                <span class="cart-badge">{{ $cart->count() }}</span>
            @endif
        </a>
    </div>
</header>

<main class="container page">
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>TechStore — учебный проект по дисциплине «Серверная веб-разработка».</p>
        <p class="muted">Московский Политех · 2026</p>
    </div>
</footer>
</body>
</html>
