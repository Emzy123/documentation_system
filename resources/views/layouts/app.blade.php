<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="d-flex">
        <!-- Sidebar for Authenticated Users -->
        @auth
            @include('layouts.sidebar')
        @endauth

        <!-- Main Content Wrapper -->
        <div class="d-flex flex-column flex-grow-1" style="height: 100vh; overflow-y: auto;">
            
            <!-- Top Navbar (Mobile Toggle for Auth, Full Nav for Guest) -->
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm {{ auth()->check() ? 'd-md-none' : '' }}">
                <div class="container-fluid">
                    <a class="navbar-brand p-0" href="{{ url('/') }}">
                        @include('components.logo')
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @auth
                                <!-- Mobile Only Navigation Links -->
                                <li class="nav-item d-md-none">
                                    <hr class="dropdown-divider">
                                    <h6 class="dropdown-header text-uppercase">Menu</h6>
                                </li>
                                @if(auth()->user()->role->slug == 'student')
                                    <li class="nav-item d-md-none">
                                        <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">My Documents</a>
                                    </li>
                                    <li class="nav-item d-md-none">
                                        <a href="{{ route('student.documents.create') }}" class="nav-link {{ request()->routeIs('student.documents.create') ? 'active' : '' }}">Upload</a>
                                    </li>
                                    <li class="nav-item d-md-none">
                                        <a href="{{ route('student.fees.index') }}" class="nav-link {{ request()->routeIs('student.fees.index') ? 'active' : '' }}">My Fees</a>
                                    </li>
                                @elseif(auth()->user()->role->slug == 'admin')
                                    <li class="nav-item d-md-none">
                                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                                    </li>
                                    <li class="nav-item d-md-none">
                                        <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
                                    </li>
                                @elseif(auth()->user()->role->slug == 'staff')
                                    <li class="nav-item d-md-none">
                                        <a href="{{ route('staff.dashboard') }}" class="nav-link">Verification</a>
                                    </li>
                                @endif
                            @endauth
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
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
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

            <main class="p-4 bg-light flex-grow-1">
                @if(auth()->check() && !request()->routeIs('welcome'))
                   <!-- Breadcrumbs or Page Title could go here -->
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
