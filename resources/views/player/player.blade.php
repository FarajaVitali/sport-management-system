<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
     <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <title>PLAYER PROFILE</title>
    <style>
        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #1e293b;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .profile-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .form-control, .form-select {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            border-radius: 8px;
            padding: 11px 14px;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: #10b981;
            color: #1e293b;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 13px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-submit:hover:not(:disabled) {
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            filter: brightness(1.05);
        }

        .brand-header {
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #0f172a;
        }
        
        .brand-accent {
            color: #10b981;
        }
    </style>
</head>

<body>
    <div class="container d-flex min-vh-100 justify-content-center align-items-center py-4">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <form class="profile-card p-4 p-sm-5 rounded-4" action="{{ route('player.info.save') }}" method="POST">
                @csrf

                <div class="text-center mb-4">
                    <h2 class="brand-header mb-1">ADD PLAYER <span class="brand-accent">INFO</span></h2>
                    <p class="text-muted small">Complete your profile setup to link with your team roster</p>
                </div>

                <!-- College Select -->
                <div class="mb-3">
                    <label class="form-label">Choose College</label>
                    <select class="form-select" id="college-select" name="college_id" required>
                        <option value="">Select College</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Team Select -->
                <div class="mb-3">
                    <label class="form-label">Choose Team</label>
                    <select class="form-select" id="team-select" name="team" required disabled>
                      
                    <option value="">Select a college first</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-submit w-100 mt-3 shadow-sm">SUBMIT PROFILE</button>
            </form>
        </div>
    </div>

<script>
    const collegeSelect = document.getElementById('college-select');
    const teamSelect = document.getElementById('team-select');

    // 1. When college changes, fetch Teams
    collegeSelect.addEventListener('change', function () {
        const collegeId = this.value;
        
        // Reset and show loading state
        teamSelect.innerHTML = '<option value="">Loading teams...</option>';
        teamSelect.disabled = true;

        if (!collegeId) {
            teamSelect.innerHTML = '<option value="">Select a college first</option>';
            return;
        }

        fetch(`/api/colleges/${collegeId}/teams`)
            .then(res => res.json())
            .then(data => {
                teamSelect.innerHTML = '<option value="">Select Team</option>';
                data.forEach(team => {
                    // Populate teams
                    teamSelect.innerHTML += `
                        <option value="${team.name}">
                            ${team.name}
                        </option>`;
                });
                teamSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching teams:', error);
                teamSelect.innerHTML = '<option value="">Error loading teams</option>';
            });
    });
</script>
</body>
</html>