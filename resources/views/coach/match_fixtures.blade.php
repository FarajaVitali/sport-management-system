@extends('layout.navbar_only')

@section('title', 'Team Match Fixtures')

@section('content')
<div class="container py-4 px-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 text-dark fw-bold">Scheduled Match Fixtures</h4>
            <p class="text-muted small mb-0">Track tournament matching structures, times, and upcoming operational events.</p>
        </div>
        <a href="{{ route('coach.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Back Dashboard
        </a>
    </div>

    <div class="row g-3">
        @forelse($fixtures as $fixture)
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm rounded-4 p-4">
                <div class="row align-items-center text-center text-md-start">
                    <div class="col-md-3">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-2 small text-uppercase tracking-wider fw-bold">
                            Round {{ $fixture->round_number ?? '1' }}
                        </span>
                        <div class="text-muted small mt-2">
                            <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($fixture->match_date)->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="col-md-6 my-3 my-md-0 d-flex align-items-center justify-content-center gap-3">
                        <div class="fw-bold text-dark text-end flex-grow-1 fs-5">{{ $fixture->homeTeam->name }}</div>
                        <span class="badge bg-light text-dark border px-3 py-2 fs-6 rounded-pill">VS</span>
                        <div class="fw-bold text-dark text-start flex-grow-1 fs-5">{{ $fixture->awayTeam->name }}</div>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3 fw-medium">
                            Confirmed Schedule
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 bg-white rounded-4 border shadow-sm text-muted">
            <i class="bi bi-calendar-x fs-3 d-block mb-2 text-secondary"></i>
            No match schedules have been generated for your roster profile yet.
        </div>
        @endforelse
    </div>
</div>
@endsection