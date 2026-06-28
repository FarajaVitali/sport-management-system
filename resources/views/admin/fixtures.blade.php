@extends('layout.navbar_only')

@section('title', 'Match Fixtures')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h4 class="fw-bold text-dark">Tournament Fixtures & Live Controls</h4>
        <p class="text-muted">Manage match status, record live goals, and view completed results.</p>
    </div>

    <div class="row g-4">
        @forelse($fixtures as $fixture)
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center justify-content-between">
                
                <div>
                    <div class="d-flex align-items-center gap-3 mb-1">
                        <span class="badge bg-light text-secondary border">Round {{ $fixture->round_number }}</span>
                        <span class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($fixture->match_date)->format('M d, Y - H:i') }}
                        </span>
                    </div>
                    <h5 class="mb-0 fw-bold text-dark">
                        {{ $fixture->homeTeam->name ?? 'TBD' }} 
                        <span class="text-muted mx-2">VS</span> 
                        {{ $fixture->awayTeam->name ?? 'TBD' }}
                    </h5>
                    <div class="small text-primary mt-1">
                        <i class="bi bi-geo-alt-fill me-1"></i> {{ $fixture->venue }}
                    </div>
                </div>

                <div class="text-end">
                    @if($fixture->status === 'scheduled')
                        <a href="{{ route('admin.live_match_panel', $fixture->id) }}" class="btn btn-primary rounded-3 px-4">
                            <i class="bi bi-play-circle me-2"></i> Go Live
                        </a>
                    @elseif($fixture->status === 'live')
                        <div class="d-flex flex-column align-items-end">
                            <span class="badge bg-danger text-white mb-2 pulse-animation">LIVE NOW</span>
                            <a href="{{ route('admin.live_match_panel', $fixture->id) }}" class="btn btn-outline-danger rounded-3 px-4">
                                Manage Score
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <span class="d-block fw-bold fs-4 text-dark mb-1">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3">Completed</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted"></i>
            <p class="text-muted mt-3">No fixtures generated yet. Go to League Structure to generate them.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .pulse-animation { animation: pulse 1.5s infinite; }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
</style>
@endsection