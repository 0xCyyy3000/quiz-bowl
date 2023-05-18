<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('icons/aclc tacloban.png') }}" type="image/x-icon">

    {{-- <title>{{ config('app.name', 'Quiz Bowl') }}</title> --}}
    <title>Quiz Bowl</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Scripts -->

    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    {{-- <script src="{{ asset('js/question-listener.js') }}"></script> --}}
    @livewireScripts
    @livewireStyles
    @vite('resources/js/app.js')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('icons/aclc tacloban.png') }}" width="50" class="me-3" alt="aclc_logo">
                    Quiz Bowl
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <div class="d-flex align-items-center gap-5">
                                <a class=" text-decoration-none text-dark fs-5">{{ Auth::user()->name }}</a>
                                <a class=" text-decoration-none" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            {{-- @auth(Auth::user()->role != 100)
                <p class="fw-semibold m-0 text-end me-5">My Team Score : {{ Auth::user()->countScore() }}</p>
            @endauth --}}
            @yield('content')
        </main>
    </div>
    <script>
        window.addEventListener('showQuestion', event => {
            alert('Hi');
        })
    </script>
</body>

</html>
