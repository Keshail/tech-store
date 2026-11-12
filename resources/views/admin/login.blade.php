<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход в админку — TechStore</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-body">
<form class="login-card" method="post" action="{{ route('admin.login.attempt') }}">
    @csrf

    <h1>TechStore</h1>
    <p class="muted">Вход в административную панель</p>

    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    <div class="field">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="field">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password" required>
    </div>

    <label class="checkbox">
        <input type="checkbox" name="remember" value="1"> Запомнить меня
    </label>

    <button class="btn btn-lg btn-block" type="submit">Войти</button>

    <p class="login-hint muted">Демо-доступ: admin@techstore.local / admin12345</p>
</form>
</body>
</html>
