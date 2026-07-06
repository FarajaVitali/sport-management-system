<!-- Inside your navigation/header file -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">Sports System</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <!-- Everyone sees this link -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rules.index') }}">Tournament Rules</a>
                </li>

                <!-- Your existing Login/Dashboard links -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>