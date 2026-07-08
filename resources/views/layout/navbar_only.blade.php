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
            <a class="navbar-brand fw-bold" href="#">Sports Portal</a>
            <!-- Cleaned up button classes -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    
                    <!-- DYNAMIC DASHBOARD LINK -->
                    @auth
                        <li class="nav-item">
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            @elseif(auth()->user()->role === 'player')
                                <a class="nav-link" href="{{ route('player.player_dashboard') }}">Dashboard</a>
                            @elseif(auth()->user()->role === 'coach')
                                <a class="nav-link" href="{{ route('coach.dashboard') }}">Dashboard</a>
                            @elseif(auth()->user()->role === 'referee')
                                <a class="nav-link" href="{{ route('referee.dashboard') }}">Dashboard</a>
                            @endif
                        </li>
                    @endauth

                    <li class="nav-item ms-3">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-sm btn-outline-light">Logout</button>
                        </form>
                    </li>
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