@extends('layout.navbar_only')

@section('title', 'Registered Coaches')

@section('content')
<div class="container py-4 px-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 text-dark fw-bold">Registered Coaches Matrix</h4>
            <p class="text-muted small mb-0">Review coach profiles, phone listings, and institutional squad assignments.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Back Dashboard
        </a>
    </div>

    <div class="row g-3">
        @forelse($coaches as $coach)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-white border-0 shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-info-subtle text-info border rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-shield-shaded fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-dark fw-bold">{{ $coach->fname }} {{ $coach->lname }}</h5>
                            <span class="text-muted small">{{ $coach->email }}</span>
                        </div>
                    </div>
                    
                    <hr class="my-2 text-muted opacity-25">

                    <div class="small my-3">
                        <div class="mb-2 text-dark">
                            <i class="bi bi-bank text-secondary me-2"></i>
                            <strong>Institution:</strong> {{ $coach->coachProfile->team->college->name ?? 'Not Assigned' }}
                        </div>
                        <div class="mb-2 text-dark">
                            <i class="bi bi-trophy text-secondary me-2"></i>
                            <strong>Team Squad:</strong> {{ $coach->coachProfile->team->name ?? 'No active assignment' }}
                        </div>
                        <div class="text-dark">
                            <i class="bi bi-telephone text-secondary me-2"></i>
                            <strong>Phone Contact:</strong> {{ $coach->coachProfile->phone_number ?? 'No contact logged' }}
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    @if($coach->coachProfile)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-2 w-100 text-center fw-medium">
                            Profile Configured
                        </span>
                    @else
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5 rounded-2 w-100 text-center fw-medium">
                            Pending Registration Setup
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 bg-white rounded-4 border shadow-sm text-muted">
            <i class="bi bi-people fs-3 d-block mb-2 text-secondary"></i>
            No coach profiles found registered in the tournament database infrastructure.
        </div>
        @endforelse
    </div>
</div>
@endsection