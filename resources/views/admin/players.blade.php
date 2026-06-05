@extends('layout.navbar_only')

@section('title', 'Registered Players')

@section('content')
<div class="container-fluid px-4 py-3">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-dark fw-bold">Registered Players</h4>
            <p class="text-muted small mb-0">Manage and review all incoming player registrations for the 2025 Season.</p>
        </div>
        <div class="badge bg-primary px-3 py-2 fs-6">
            Total Players: {{ count($users) }}
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-white rounded-3 p-3">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search players by name or email...">
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-funnel-fill me-1"></i> Filter Team</button>
                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> Export Excel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom text-uppercase fs-7 tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-semibold">#</th>
                        <th class="py-3 text-muted fw-semibold">Player Name</th>
                        <th class="py-3 text-muted fw-semibold">Email</th>
                        <th class="py-3 text-muted fw-semibold">College / Institution</th>
                        <th class="py-3 text-muted fw-semibold">Team</th>
                        <th class="py-3 text-muted fw-semibold">Position</th>
                        <th class="py-3 text-muted fw-semibold text-center">Status</th>
                        <th class="py-3 text-muted fw-semibold text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="border-bottom-0">
                        <td class="ps-4 fw-medium text-secondary">{{ $user->id }}</td>
                        
                        <td class="fw-semibold text-dark">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($user->fname, 0, 1)) }}
                                </div>
                                <div>{{ $user->fname }} {{ $user->lname }}</div>
                            </div>
                        </td>
                        
                        <td class="text-secondary">{{ $user->email }}</td>
                        
                        <td>
                            <span class="text-dark">
                                <i class="bi bi-building text-muted me-1"></i> 
                                {{ $user->playerProfile->college->name ?? 'N/A' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1.5 fw-medium">
                                {{ $user->playerProfile->team ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="text-muted font-monospace small">
                            {{ $user->playerProfile->position ?? 'N/A' }}
                        </td>

                        <td class="text-center">
                            <span class="badge rounded-pill px-3 py-1.5 fw-semibold
                                @if(($user->status ?? 'pending') == 'active') bg-success-subtle text-success border border-success-subtle
                                @elseif(($user->status ?? 'pending') == 'banned') bg-danger-subtle text-danger border border-danger-subtle
                                @else bg-warning-subtle text-warning-emphasis border border-warning-subtle
                                @endif">
                                {{ ucfirst($user->status ?? 'pending') }}
                            </span>
                        </td>
                        
                        <td class="text-end pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                @if(($user->status ?? 'pending') !== 'active')
                                <form action="{{ route('admin.allow', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to approve this player?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light text-success border border-success-subtle d-inline-flex align-items-center gap-1" title="Approve Player">
                                        <i class="bi bi-check-circle me-1"></i> Allow
                                    </button>
                                </form>
                                @endif

                                @if(($user->status ?? 'pending') !== 'banned')
                                <form action="{{ route('admin.ban', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to suspend this player?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light text-danger border border-danger-subtle d-inline-flex align-items-center gap-1" title="Ban Player">
                                        <i class="bi bi-slash-circle me-1"></i> Ban
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                            No registered players discovered in the database system.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection