<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CPIV') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/frappe.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/vendor/fontawesome/css/all.min.css" rel="stylesheet" >
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'CPIV') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav ml-auto">
                        @if($loggedIn->administrator)
                        <li class="nav-item mr-4">
                            <a href="/home" class="nav-link {{ Request::is(['home']) ? 'active' : null }}">
                                <i class="fa fa-home mr-2"></i>
                                Dashboard
                            </a>
                        </li>
                        @endif
                        @if($loggedIn->administrator)
                        <li class="nav-item mr-4">
                            <a href="/accounts" class="nav-link {{ Request::is(['accounts', 'accounts/types/new', 'accounts/types', 'accounts/assign']) ? 'active' : null }}">
                                <i class="fa fa-users mr-2"></i>
                                Manage Accounts
                            </a>
                        </li>
                        @endif
                        @if($loggedIn->RHA)
                        <li class="nav-item mr-4">
                            <a href="/projects/pending" class="nav-link {{ Request::is(['projects', 'projects/*']) ? 'active' : null }}">
                                <i class="fa fa-boxes mr-2"></i>
                                Manage Projects
                            </a>
                        </li>
                        @endif
                        @if($loggedIn->project)
                        <li class="nav-item mr-4">
                            <a href="/projects" class="nav-link {{ Request::is(['projects', 'projects/*']) ? 'active' : null }}">
                                <i class="fa fa-boxes mr-2"></i>
                                Manage Projects
                            </a>
                        </li>
                        @endif
                        @if($loggedIn->investor)
                        <li class="nav-item mr-4">
                            <a href="/investments" class="nav-link {{ Request::is(['investments', 'investments/*']) ? 'active' : null }}">
                                <i class="fa fa-money-bill-wave mr-2"></i>
                                Investments
                            </a>
                        </li>
                        @endif
                        @if($loggedIn->RDB)
                        <li class="nav-item mr-4">
                            <a href="/investments/pending" class="nav-link {{ Request::is(['investments', 'investments/*']) ? 'active' : null }}">
                                <i class="fa fa-money-bill-wave mr-2"></i>
                                Manage Investments
                            </a>
                        </li>
                        @endif
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is(['login']) ? 'active' : null }}" href="{{ route('login') }}">
                                        <i class="fa fa-sign-in-alt mr-2"></i>
                                        Login
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is(['register']) ? 'active' : null }}" href="{{ route('register') }}">
                                        <i class="fa fa-user-plus mr-2"></i>
                                        Register
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle {{ Request::is(['profile']) ? 'active' : null }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user mr-2"></i>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">
                                        <i class="fa fa-cogs mr-2"></i>
                                        My Profile
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out-alt mr-2"></i>
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
