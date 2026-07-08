<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sports Portal')</title>
    <!-- Bootstrap & Icons -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Navbar Wrapper -->
    @include('partials.navbar')

    <div class="d-flex">
        <!-- Sidebar Wrapper -->
        @include('partials.admin_sidebar')

        <!-- Main Content Area where player.blade.php injects its data -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

 <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>