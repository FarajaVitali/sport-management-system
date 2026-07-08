<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <title>REGISTER PAGE</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .register-card {
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }
        /* Enhanced focus state to include the new select dropdown */
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center py-5 min-vh-100">
        <div class="col-10 col-sm-8 col-md-7 col-lg-5">
            
            <div class="card register-card border-0 shadow-lg p-4 p-sm-5">
                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div class="text-center mb-2">
                        <h3 class="fw-bold text-dark mb-1">Create Account</h3>
                        <p class="text-muted small">Join the sports portal team management system</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong class="small">Please fix the following:</strong>
                            </div>
                            <ul class="mb-0 small ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label text-secondary small fw-semibold">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" name="fname" value="{{ old('fname') }}" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label text-secondary small fw-semibold">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" name="lname" value="{{ old('lname') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control bg-light border-start-0" name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control bg-light border-start-0" name="password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-check"></i></span>
                            <input type="password" class="form-control bg-light border-start-0" name="password_confirmation" required>
                        </div>
                    </div>

                    <!-- Clean Input-Group Dropdown Design -->
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Account Role Type</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-badge"></i></span>
                            <select class="form-select bg-light border-start-0 text-secondary small" name="role" required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Account Type</option>
                                <option value="fan" {{ old('role') == 'fan' ? 'selected' : '' }}>Fan/Supporter</option>
                                <option value="player" {{ old('role') == 'player' ? 'selected' : '' }}>Player</option>
                                <option value="coach" {{ old('role') == 'coach' ? 'selected' : '' }}>Coach</option>
                                <option value="referee" {{ old('role') == 'referee' ? 'selected' : '' }}>Referee</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-semibold shadow-sm mb-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Complete Registration
                    </button>

                    <div class="text-center mt-2">
                        <p class="small text-muted mb-0">Already registered? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign In Here</a></p>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>