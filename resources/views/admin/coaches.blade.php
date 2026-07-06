@extends('layout.navbar_only')

@section('title', 'Registered Coaches')

@section('content')
<div class="container-fluid px-4 py-3">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-dark fw-bold">Registered Coaches</h4>
            <p class="text-muted small mb-0">Manage and review all institutional coach accounts and squad profile assignments.</p>
        </div>
        <div class="badge bg-primary px-3 py-2 fs-6">
            Total Coaches: {{ count($coaches) }}
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
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search coaches by name or email...">
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-funnel-fill me-1"></i> Filter Institution</button>
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
                        <th class="py-3 text-muted fw-semibold">Coach Name</th>
                        <th class="py-3 text-muted fw-semibold">Email</th>
                        <th class="py-3 text-muted fw-semibold">Institution</th>
                        <th class="py-3 text-muted fw-semibold">Assigned Team</th>
                        <th class="py-3 text-muted fw-semibold">Phone Contact</th>
                        <th class="py-3 text-muted fw-semibold text-center">Status</th>
                        <th class="py-3 text-muted fw-semibold text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coaches as $coach)
                    <tr class="border-bottom-0">
                        <td class="ps-4 fw-medium text-secondary">{{ $coach->id }}</td>
                        
                        <td class="fw-semibold text-dark">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-info fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($coach->fname, 0, 1)) }}
                                </div>
                                <div>{{ $coach->fname }} {{ $coach->lname }}</div>
                            </div>
                        </td>
                        
                        <td class="text-secondary">{{ $coach->email }}</td>
                        
                        <td>
                            <span class="text-dark">
                                <i class="bi bi-bank text-muted me-1"></i> 
                                {{ $coach->coachProfile->team->college->name ?? 'Not Assigned' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1.5 fw-medium">
                                {{ $coach->coachProfile->team->name ?? 'No active assignment' }}
                            </span>
                        </td>

                        <td class="text-muted font-monospace small">
                            {{ $coach->coachProfile->phone_number ?? 'No contact logged' }}
                        </td>

                        <td class="text-center">
                            <span class="badge rounded-pill px-3 py-1.5 fw-semibold
                                @if(($coach->status ?? 'pending') == 'active') bg-success-subtle text-success border border-success-subtle
                                @elseif(($coach->status ?? 'pending') == 'banned') bg-danger-subtle text-danger border border-danger-subtle
                                @else bg-warning-subtle text-warning-emphasis border border-warning-subtle
                                @endif">
                                {{ ucfirst($coach->status ?? 'pending') }}
                            </span>
                        </td>
                        
                        <td class="text-end pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                @if(($coach->status ?? 'pending') !== 'active')
                                <form action="{{ route('admin.allow', $coach->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to approve this coach account?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light text-success border border-success-subtle d-inline-flex align-items-center gap-1" title="Approve Coach">
                                        <i class="bi bi-check-circle me-1"></i> Allow
                                    </button>
                                </form>
                                @endif

                                @if(($coach->status ?? 'pending') !== 'banned')
                                <form action="{{ route('admin.ban', $coach->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to suspend this coach profile? This blocks access parameters immediately.');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light text-danger border border-danger-subtle d-inline-flex align-items-center gap-1" title="Ban Coach">
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
                            No coach profiles found registered in the tournament database infrastructure.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection