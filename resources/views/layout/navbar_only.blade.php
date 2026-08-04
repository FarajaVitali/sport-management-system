<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Sports Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    
                    <!-- PUBLIC LINKS (Visible to everyone) -->
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('fixtures.public') }}">Fixtures</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('standings.public') }}">Standings</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('rules.index') }}">Rules</a></li>

                    <!-- AUTHENTICATED USERS (Only visible if logged in) -->
                    @auth
                        <!-- Dynamic Dashboard Link -->
                        <li class="nav-item ms-2 border-start ps-3 border-secondary border-opacity-50">
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link text-warning fw-semibold" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            @elseif(auth()->user()->role === 'player')
                                <a class="nav-link text-warning fw-semibold" href="{{ route('player.player_dashboard') }}">Dashboard</a>
                            @elseif(auth()->user()->role === 'coach')
                                <a class="nav-link text-warning fw-semibold" href="{{ route('coach.dashboard') }}">Dashboard</a>
                            @elseif(auth()->user()->role === 'referee')
                                <a class="nav-link text-warning fw-semibold" href="{{ route('referee.dashboard') }}">Dashboard</a>
                            @endif
                        </li>
                        
                        <!-- Logout Button -->
                        <li class="nav-item ms-3">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </li>
                    @endauth

                    <!-- GUESTS (Only visible if NOT logged in) -->
                    @guest
                        <li class="nav-item ms-3 border-start ps-3 border-secondary border-opacity-50">
                            <a class="btn btn-sm btn-outline-light me-2" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-light fw-bold text-dark" href="{{ route('register.form') }}">Register</a>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>