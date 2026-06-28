@extends('layout.navbar_only')

@section('title', 'My Profile')

@section('content')
<div class="container py-4 px-4" style="max-width: 800px;">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-dark fw-bold">Account Verification Profile</h4>
        <a href="{{ route('coach.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <div class="card bg-white border-0 shadow-sm rounded-4 p-4 text-center mb-4">
        <div class="mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px; font-size: 2rem; font-weight: 700;">
            {{ strtoupper(substr($user->fname, 0, 1)) }}
        </div>
        <h4 class="fw-bold text-dark mb-1">{{ $user->fname }} {{ $user->lname }}</h4>
        <span class="badge bg-dark-subtle text-dark px-3 py-1.5 rounded-pill small fw-semibold">Official Head Coach</span>
    </div>

    <div class="card bg-white border-0 shadow-sm rounded-4 p-4">
        <h6 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="bi bi-info-circle text-primary me-2"></i>Profile Specifications</h6>
        
        <div class="row g-3 small">
            <div class="col-sm-6">
                <div class="text-secondary fw-medium">Registered Account Email</div>
                <div class="text-dark fw-bold fs-6 mt-0.5">{{ $user->email }}</div>
            </div>
            <div class="col-sm-6">
                <div class="text-secondary fw-medium">Assigned Club / College</div>
                <div class="text-dark fw-bold fs-6 mt-0.5">{{ $user->coachProfile->team->college->name ?? 'Not Set' }}</div>
            </div>
            <div class="col-sm-6">
                <div class="text-secondary fw-medium">Assigned Managed Squad</div>
                <div class="text-warning-dark fw-bold fs-6 mt-0.5"><i class="bi bi-shield-check me-1"></i> {{ $user->coachProfile->team->name ?? 'Vacant' }}</div>
            </div>
            <div class="col-sm-6">
                <div class="text-secondary fw-medium">Coach ID Assignment</div>
                <div class="text-dark font-monospace mt-0.5">ID_REF_{{ $user->coachProfile->id ?? '0' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection