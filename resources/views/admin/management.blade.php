@extends('layout.navbar_only')

@section('title', 'System Management Setup')

@section('content')
<style>
    body {
        background-color: #f8fafc;
        color: #1e293b;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        overflow-x: hidden;
    }

    .navbar, [role="navigation"] {
        position: sticky !important;
        top: 0;
        z-index: 1030;
        box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.05);
    }
    
    .admin-layout-wrapper {
        display: flex;
        min-height: calc(100vh - 56px);
    }

    .admin-sidebar-panel {
        width: 360px;
        position: fixed;
        top: 56px;
        left: 0;
        bottom: 0;
        overflow-y: auto;
        padding: 1.5rem;
        background-color: #f8fafc;
        border-right: 1px solid #e2e8f0;
        z-index: 1010;
    }

    .admin-main-viewport {
        margin-left: 360px;
        flex-grow: 1;
        padding: 1.5rem 2rem;
        overflow-y: auto;
    }
    
    .custom-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.05), 0 2px 4px -2px rgba(15, 23, 42, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .custom-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.08);
    }

    .form-control-custom, .form-select-custom {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        background-color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        outline: none;
    }

    .btn-action-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        color: #ffffff;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-action-primary:hover {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        filter: brightness(1.05);
    }

    .btn-action-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: #ffffff;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-action-success:hover {
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        filter: brightness(1.05);
    }

    .interactive-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .interactive-table tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .badge-vacant {
        background-color: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .badge-assigned {
        background-color: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-weight: 500;
    }

    .admin-sidebar-panel::-webkit-scrollbar {
        width: 4px;
    }
    .admin-sidebar-panel::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    @media (max-width: 991.98px) {
        .admin-layout-wrapper { display: block; }
        .admin-sidebar-panel { position: static; width: 100%; border-right: none; border-bottom: 1px solid #e2e8f0; padding: 1rem; }
        .admin-main-viewport { margin-left: 0; padding: 1rem; }
    }
</style>

<div class="admin-layout-wrapper">
    
    <aside class="admin-sidebar-panel">
        <div class="card custom-card rounded-4 border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0 rounded-top-4">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <i class="bi bi-bank text-primary me-2 fs-5"></i> Register New College
                </h6>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('admin.store_college') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">College Title</label>
                        <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" placeholder="e.g., ATC" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-action-primary w-100 py-2">Save College</button>
                </form>
            </div>
        </div>

        <div class="card custom-card rounded-4 border-0 overflow-hidden">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item bg-light-subtle py-3 fw-bold text-secondary border-bottom">
                        Currently Configured Colleges
                    </li>
                    @forelse($colleges as $college)
                        <li class="list-group-item d-flex justify-content-between align-items-center text-dark fw-medium py-2.5 transition-all">
                            <span><i class="bi bi-building text-muted me-2"></i>{{ $college->name }}</span>
                            <span class="badge bg-slate-100 text-secondary border rounded-pill font-monospace small">ID: {{ $college->id }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-4">No active colleges found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </aside>

    <main class="admin-main-viewport">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3 p-3 d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i> 
                <div class="fw-medium text-success-tight">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4">
            <h4 class="mb-1 text-dark fw-bold tracking-tight">League Structure Management</h4>
            <p class="text-muted small mb-0">Provision authorized institutions, regional colleges, and specific active team rosters directly.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white border-start border-primary border-4">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <div>
                    <h6 class="mb-1 fw-bold text-dark">League Schedule Automation</h6>
                    <p class="text-muted small mb-0">Instantly generate matches timeline once all teams are configured.</p>
                </div>
                <form action="{{ route('admin.generate_fixtures') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-action-primary shadow-sm rounded-3 fw-semibold px-4 py-2" onclick="return confirm('Are you sure you want to regenerate all match fixtures? This will wipe the existing schedule.');">
                        Generate Match Fixtures
                    </button>
                </form>
            </div>
        </div>

        <!-- TEAM DEPLOYMENT CARD -->
        <div class="card custom-card rounded-4 border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0 rounded-top-4">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <i class="bi bi-shield-plus text-success me-2 fs-5"></i> Deploy New Team Profile
                </h6>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('admin.store_team') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Belongs to Parent College</label>
                            <select name="college_id" id="team_college_id" class="form-select form-select-custom" required>
                                <option value="" disabled selected>-- Select Affiliated College --</option>
                                @foreach($colleges as $col)
                                    <option value="{{ $col->id }}" data-name="{{ $col->name }}">{{ $col->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Sport Type</label>
                            <select name="sport_id" id="team_sport_id" class="form-select form-select-custom" required>
                                <option value="" disabled selected>-- Select Sport Type --</option>
                                @foreach($sports as $sport) 
                                    <option value="{{ $sport->id }}" data-name="{{ ucfirst($sport->name) }}">{{ ucfirst($sport->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Division Category</label>
                            <select name="gender" id="team_gender_id" class="form-select form-select-custom" required>
                                <option value="men" selected>Men's Division</option>
                                <option value="women">Women's Division</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-slate-700">System Generated Team Title</label>
                            <input type="text" name="name" id="generated_team_name" class="form-control form-control-custom bg-light border-primary-subtle font-monospace text-primary fw-bold" placeholder="Waiting for selection..." readonly required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-semibold text-secondary">Assign Head Coach</label>
                            <select name="coach_id" id="coach_id" class="form-select form-select-custom">
                                <option value="" selected>-- Leave Unassigned (Vacant) --</option>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}">
                                        {{ $coach->fname }} {{ $coach->lname }} ({{ $coach->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-action-success mt-4 d-block ms-auto px-4 py-2">Assemble Team</button>
                </form>
            </div>
        </div>

        <!-- TEAMS REGISTER DISPLAY TABLE -->
        <div class="card custom-card rounded-4 border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small interactive-table">
                    <thead class="table-light text-uppercase tracking-wider border-bottom text-secondary">
                        <tr>
                            <th class="ps-4 py-3 fw-bold">Team Name</th>
                            <th class="py-3 fw-bold">Parent Institution</th>
                            <th class="py-3 fw-bold">Sport Category</th>
                            <th class="py-3 fw-bold">Division</th>
                            <th class="py-3 fw-bold">Head Coach</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teams as $team)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark py-3">{{ $team->name }}</td>
                            <td class="text-secondary"><i class="bi bi-building me-1.5 text-muted"></i> {{ $team->college->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 rounded-2">
                                    {{ $team->sport->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark border px-2.5 py-1.5 rounded-2 text-uppercase font-monospace small">
                                    {{ $team->gender }} <!-- RENDERS ACCURATE VALUE DIRECT FROM DB -->
                                </span>
                            </td>
                            <td>
                                @if($team->coachProfile && $team->coachProfile->user)
                                    <span class="badge badge-assigned px-2.5 py-1.5 rounded-2">
                                        <i class="bi bi-person-badge me-1"></i> 
                                        {{ $team->coachProfile->user->fname }} {{ $team->coachProfile->user->lname }}
                                    </span>
                                @else
                                    <span class="badge badge-vacant px-2.5 py-1.5 rounded-2">
                                        <i class="bi bi-exclamation-circle me-1"></i> Vacant (TBD)
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fw-medium">
                                <i class="bi bi-inbox fs-4 d-block mb-2 text-secondary"></i>
                                No operational teams configured yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const collegeSelect = document.getElementById('team_college_id');
        const sportSelect = document.getElementById('team_sport_id');
        const genderSelect = document.getElementById('team_gender_id');
        const nameInput = document.getElementById('generated_team_name');

        function generateTeamTitle() {
            const selectedCollege = collegeSelect.options[collegeSelect.selectedIndex];
            const selectedSport = sportSelect.options[sportSelect.selectedIndex];
            
            const collegeName = selectedCollege ? selectedCollege.getAttribute('data-name') : '';
            const sportName = selectedSport ? selectedSport.getAttribute('data-name') : '';
            const genderRaw = genderSelect.value;
            
            const genderFormatted = genderRaw ? `(${genderRaw.charAt(0).toUpperCase() + genderRaw.slice(1)})` : '';

            if (collegeName && sportName) {
                nameInput.value = `${collegeName} ${sportName} ${genderFormatted}`.trim();
            } else {
                nameInput.value = '';
            }
        }

        collegeSelect.addEventListener('change', generateTeamTitle);
        sportSelect.addEventListener('change', generateTeamTitle);
        genderSelect.addEventListener('change', generateTeamTitle);
    });
</script>
@endsection