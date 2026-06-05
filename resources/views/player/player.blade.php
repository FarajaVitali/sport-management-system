<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:disabled, .form-select:disabled {
            background-color: #f1f5f9;
            border-color: #e2e8f0;
            color: #94a3b8;
            opacity: 0.7;
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

        .btn-submit:active {
            filter: brightness(0.95);
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

                <div class="mb-3">
                    <label class="form-label">Choose College</label>
                    <select class="form-select" id="college-select" name="college_id" required>
                        <option value="">Select College</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Choose Team</label>
                    <select class="form-select" id="team-select" name="team" required disabled>
                        <option value="">Select a college first</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-sm-5 mb-3">
                        <label class="form-label">Jersey Number</label>
                        <input type="number" class="form-control" name="jersey_number" min="0" max="99" placeholder="e.g., 10" required>
                    </div>
                    <div class="col-sm-7 mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control" name="position" placeholder="e.g., Striker, Guard" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit w-100 mt-3 shadow-sm">SUBMIT PROFILE</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('college-select').addEventListener('change', function () {
            const collegeId = this.value;
            const teamSelect = document.getElementById('team-select');

            if (!collegeId) {
                teamSelect.innerHTML = '<option value="">Select a college first</option>';
                teamSelect.disabled = true;
                return;
            }

            teamSelect.innerHTML = '<option value="">Loading teams...</option>';
            teamSelect.disabled = true;

            fetch(`/api/colleges/${collegeId}/teams`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server returned HTTP status ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    teamSelect.innerHTML = '<option value="">Select Team</option>';
                    
                    if (data && data.length > 0) {
                        data.forEach(team => {
                            teamSelect.innerHTML += `<option value="${team.name}">${team.name}</option>`;
                        });
                        teamSelect.disabled = false;
                    } else {
                        teamSelect.innerHTML = '<option value="">No teams available for this college</option>';
                        teamSelect.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error fetching teams:', error);
                    teamSelect.innerHTML = '<option value="">Error loading teams</option>';
                    teamSelect.disabled = true;
                });
        });
    </script>
</body>

</html>