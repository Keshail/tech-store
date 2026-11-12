<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админка') — TechStore</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body">
<aside class="admin-sidebar">
    <a class="admin-brand" href="{{ route('admin.dashboard') }}">
        <span class="admin-brand__mark">TS</span>
        <span class="admin-brand__text">
            <strong>TechStore</strong>
            <small>панель управления</small>
        </span>
    </a>

    <nav class="admin-nav">
        <span class="admin-nav__label">Магазин</span>

        <a class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13h6V4H4v9Zm0 7h6v-5H4v5Zm10 0h6v-9h-6v9Zm0-16v5h6V4h-6Z"/></svg>
            <span>Дашборд</span>
        </a>

        <a class="{{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}"
           href="{{ route('admin.products.index') }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 3 6.5v11L12 22l9-4.5v-11L12 2Zm0 2.3 6.3 3.2L12 10.7 5.7 7.5 12 4.3ZM5 9.2l6 3v7.4l-6-3V9.2Zm8 10.4v-7.4l6-3v7.4l-6 3Z"/></svg>
            <span>Товары</span>
        </a>

        <a class="{{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}"
           href="{{ route('admin.categories.index') }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 2 8l10 5 10-5-10-5Zm-8.6 7.4L12 14.6l8.6-4.2 1.4.7-10 4.9-10-4.9 1.4-.7Zm0 4L12 18.6l8.6-4.2 1.4.7-10 4.9-10-4.9 1.4-.7Z"/></svg>
            <span>Категории</span>
        </a>

        <span class="admin-nav__label">Продажи</span>

        <a class="{{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}"
           href="{{ route('admin.orders.index') }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 2h9l5 5v15H6V2Zm2 2v16h10V8h-4V4H8Zm2 6h6v2h-6v-2Zm0 4h6v2h-6v-2Z"/></svg>
            <span>Заказы</span>
        </a>
    </nav>

    <div class="admin-sidebar__foot">
        <a class="admin-sidebar__link" href="{{ route('home') }}" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 3h7v7h-2V6.4l-8.3 8.3-1.4-1.4L17.6 5H14V3ZM5 5h6v2H7v10h10v-4h2v6H5V5Z"/></svg>
            Открыть витрину
        </a>

        <div class="admin-user">
            <span class="admin-user__avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
            <span class="admin-user__info">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ auth()->user()->email }}</small>
            </span>
        </div>

        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button class="admin-logout" type="submit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 3H5v18h5v-2H7V5h3V3Zm5.6 4.6L14.2 9l2 2H10v2h6.2l-2 2 1.4 1.4L20 12l-4.4-4.4Z"/></svg>
                Выйти
            </button>
        </form>
    </div>
</aside>

<main class="admin-main">
    <header class="admin-topbar">
        <div class="admin-topbar__titles">
            <nav class="admin-breadcrumbs">
                <a href="{{ route('admin.dashboard') }}">Админка</a>
                @hasSection('crumb')
                    <span>/</span>
                    <span class="current">@yield('crumb')</span>
                @endif
            </nav>
            <h1>@yield('heading', 'Админка')</h1>
            @hasSection('subtitle')
                <p class="admin-subtitle">@yield('subtitle')</p>
            @endif
        </div>

        <div class="admin-topbar__actions">
            @yield('actions')
        </div>
    </header>

    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    <div class="admin-content">
        @yield('content')
    </div>
</main>
</body>
</html>
