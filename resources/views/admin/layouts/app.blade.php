<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="alpineApp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{asset('build/assets/app.css')}}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.1/dist/cdn.min.js"></script>
    <!-- Custom styles for this Page-->
    @yield('custom_styles')
</head>
<body :class="dark ? 'theme-dark' : 'theme-light'" :data-bs-theme="dark ? 'dark' : 'light'">
<div class="page">
    <div class="sticky-top">
        <header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="{{route('home')}}" class="rounded">
                        <img src="{{asset('logo.png')}}" width="145" style="height: 2.5rem" alt="Logo" class="navbar-brand-image">
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex me-2">
                        <a x-cloak href="#" @click.prevent="toggleTheme()" class="nav-link px-0" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Enable light mode" :data-bs-original-title="dark ? `Включить светлую тему` : `Включить тёмную тему`">
                            <span x-cloak x-show="!dark"><x-svg.moon></x-svg.moon></span>
                            <span x-cloak x-show="dark"><x-svg.sun></x-svg.sun></span>
                        </a>
                    </div>
                    @auth
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                                <span class="avatar avatar-sm" style="background-image: url(https://eu.ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }})"></span>
                                <div class="d-none d-xl-block ps-2">
                                    {{ auth()->user()->name ?? null }}
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="{{ route('profile.show') }}" class="dropdown-item">Аккаунт</a>
                                <div class="dropdown-divider my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Выйти
                                    </a>
                                </form>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </header>

        @include('admin.layouts.navigation')

    </div>
    <div class="page-wrapper">
        @include('admin.layouts.includes.messages')
        @yield('content')

        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                &copy; {{ date('Y') }}
                                <a href="{{ config('app.url') }}" class="link-secondary">{{ config('app.name') }}</a>
                            </li>
                            <li class="list-inline-item">
                                Version 1.0.0
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
</div>

<!-- Core plugin JavaScript-->
<script src="{{asset('build/assets/app.js')}}"></script>
@include('admin.layouts.includes._alpine-init')
<!-- Page level custom scripts -->
@yield('custom_scripts')

</body>
</html>
