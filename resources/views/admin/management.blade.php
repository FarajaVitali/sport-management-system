@extends('layout.navbar_only')

@section('title', 'System Management Setup')

@section('content')
<div class="container-fluid px-4 py-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-4">
        <h4 class="mb-1 text-dark fw-bold">League Structure Architecture Management</h4>
        <p class="text-muted small mb-0">Provision authorized institutions, regional colleges, and specific active team rosters directly.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-bank text-primary me-2"></i> Register New College</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.store_college') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">College Title / Abbreviation</label>
                            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="e.g., ATC" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">Save College Node</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item bg-light fw-bold text-secondary">Currently Configured Colleges</li>
                        @forelse($colleges as $college)
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark fw-medium">
                                <span><i class="bi bi-building text-muted me-2"></i>{{ $college->name }}</span>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">ID: {{ $college->id }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">No active colleges found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="card border-0 shadow-sm rounded-3 mb-4 bg-light-subtle border-start border-primary border-3">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">League Schedule Automation Engine</h6>
                        <p class="text-muted small mb-0">Instantly generate a balanced round-robin match timeline once all teams are configured.</p>
                    </div>
                    <form action="{{ route('admin.generate_fixtures') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm rounded-3 fw-medium px-3" onclick="return confirm('Are you sure you want to regenerate all match fixtures? This will wipe the existing schedule.');">
                            <i class="bi bi-gear-wide-connected me-1"></i> Auto-Generate Match Fixtures
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-plus text-success me-2"></i> Deploy New Team Profile</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.store_team') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Belongs to Parent College</label>
                                <select name="college_id" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Select Affiliated College --</option>
                                    @foreach($colleges as $col)
                                        <option value="{{ $col->id }}">{{ $col->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Sport Type Category</label>
                                <select name="sport_id" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Select Sport Type --</option>
                                    @foreach($sports as $sport)
                                        <option value="{{ $sport->id }}">{{ ucfirst($sport->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Unique Team Roster Full Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g., ATC-Football" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Assigned Head Coach Name</label>
                                <input type="text" name="coach_name" class="form-control form-control-sm" placeholder="e.g., Coach Sarah">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success mt-3 d-block ms-auto px-4">Assemble Team</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light text-uppercase tracking-wider">
                            <tr>
                                <th class="ps-3 py-2.5 text-muted fw-semibold">Team Name</th>
                                <th class="py-2.5 text-muted fw-semibold">Parent Institution</th>
                                <th class="py-2.5 text-muted fw-semibold">Sport</th>
                                <th class="py-2.5 text-muted fw-semibold">Head Coach</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teams as $team)
                            <tr class="border-bottom-0">
                                <td class="ps-3 fw-bold text-dark">{{ $team->name }}</td>
                                <td class="text-secondary"><i class="bi bi-building me-1"></i> {{ $team->college->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                        {{ $team->sport->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-muted font-monospace">{{ $team->coach_name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No operational teams configured yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection