<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sport Management System</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            /* Premium gradient background matching the sports theme */
            background: linear-gradient(135deg, #f0f7ff 0%, #e2e8f0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none !important;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08) !important;
            border-radius: 16px !important;
        }
        /* Custom styling to place icons cleanly inside floating labels */
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #64748b;
        }
        .form-control-icon-ready {
            border-left: none;
        }
        .form-control-icon-ready:focus {
            border-color: #dee2e6;
            box-shadow: none;
        }
        .input-group:focus-within {
            border-radius: 0.375rem;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #2563eb;
        }
        .btn-primary {
            background-color: #2563eb;
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .brand-logo {
            color: #2563eb;
            font-size: 28px;
        }
    </style>
</head>
<body>

    <div class="container d-flex vh-100 justify-content-center align-items-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
            
            <div class="text-center mb-4">
                <div class="brand-logo mb-2"><i class="fa-solid fa-trophy"></i></div>
                <h3 class="fw-bold text-dark m-0">Welcome Back</h3>
                <p class="text-muted small mt-1">Sign in to access your sports dashboard</p>
            </div>

            <form class="login-card p-4 p-sm-5 bg-white" action="{{ route('login') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0 small ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" class="form-control form-control-icon-ready" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control form-control-icon-ready" name="password" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 small">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label text-muted">Remember me</label>
                    </div>
                    <a href="{{ route('register') ?? '# ' }}" class="text-decoration-none fw-medium text-primary">Forgot Password?</a>
                </div>

                <button type="submit" class="mt-4 btn btn-primary w-100 rounded-3">Sign In</button>

                <p class="text-center mt-4 small text-muted mb-0">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">Register Here</a>
                </p>
            </form>
            
        </div>
    </div>

</body>
</html>