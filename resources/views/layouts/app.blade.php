<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Система баланса пользователей</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Система баланса</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    @auth
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="nav-link px-3 bg-dark border-0" type="submit">Выход</button>
                </form>
            </div>
        </div>
    @endauth
</header>

<div class="container-fluid">
    <div class="row">
        @auth
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                                Главная
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('transactions') ? 'active' : '' }}" href="/transactions">
                                История операций
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        @endauth

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">@yield('title', 'Панель управления')</h1>
            </div>
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
