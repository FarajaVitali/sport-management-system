@extends('layout.navbar_only')

@section('title', 'Match Schedule')

@section('content')
<div class="container-fluid px-4 py-5">
    
    <div class="text-center mb-4 header-section">
        <h2 class="fw-bolder text-dark display-6 mb-2">Tournament Schedule</h2>
        <p class="text-muted fs-5">Upcoming fixtures and live updates for the Shimivuta Sports League</p>
    </div>

    @php
        // Dynamically extract unique sports from upcoming matches for filter options
        $sports = $upcoming->map(function($fixture) {
            return $fixture->sport_category ?? ($fixture->sport->name ?? null);
        })->unique()->filter()->sort();
    @endphp

    <!-- Dynamic Sport Categories Filter Row -->
    @if($upcoming->count() > 0 && $sports->count() > 0)
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">
            <button class="nav-link fw-bold px-4 py-2 rounded-pill custom-filter-btn active" data-filter="all">
                <i class="bi bi-grid-fill me-2"></i>All Sports
            </button>
            @foreach($sports as $sport)
                <button class="nav-link fw-bold px-4 py-2 rounded-pill custom-filter-btn" data-filter="{{ Str::slug($sport) }}">
                    {{ $sport }}
                </button>
            @endforeach
        </div>
    @endif

    <!-- Upcoming Fixtures Container -->
    <div class="row g-3 d-flex flex-column align-items-center" id="fixtures-container">
        @forelse($upcoming as $index => $fixture)
            @php
                // Generate a matching slug identifier for the data attribute
                $fixtureSport = $fixture->sport_category ?? ($fixture->sport->name ?? 'other');
                $sportSlug = Str::slug($fixtureSport);
            @endphp
            
            <div class="col-12 col-md-10 col-lg-8 card-enter fixture-item" 
                 data-sport="{{ $sportSlug }}" 
                 style="animation-delay: {{ $index * 0.05 }}s" 
                 id="fixture-{{ $fixture->id }}">
                 
                <div class="card border-0 rounded-3 overflow-hidden match-card">
                    <div class="px-4 py-2 d-flex justify-content-between align-items-center match-header">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge {{ $fixture->status == 'live' ? 'bg-danger live-badge' : ($fixture->status == 'completed' ? 'bg-success' : 'bg-secondary') }}" style="font-size: 0.75rem;">
                                {{ strtoupper($fixture->status) }}
                            </span>
                            <!-- Contextual sport category label inside match header -->
                            <span class="text-xs fw-bold text-uppercase text-muted tracking-wider" style="font-size: 0.7rem;">
                                {{ $fixtureSport }}
                            </span>
                        </div>
                        <small class="text-muted fw-bold match-date">
                            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($fixture->match_date)->format('M d, Y') }}
                        </small>
                    </div>
                    <div class="card-body py-3 px-4"> 
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-center w-35 team-container">
                                <h5 class="fw-bold text-uppercase text-truncate team-name mb-0" title="{{ $fixture->homeTeam->name ?? 'TBD' }}">
                                    {{ $fixture->homeTeam->name ?? 'TBD' }}
                                </h5>
                            </div>
                            
                            <div class="text-center px-2 w-30" id="center-container-{{ $fixture->id }}">
                                @if($fixture->status == 'scheduled')
                                    <div class="scheduled-info-box">
                                        <div class="vs-text fw-extrabold text-primary mb-1">VS</div>
                                        <div class="match-time fw-bold text-dark small mb-1">
                                            <i class="bi bi-clock-fill me-1 text-secondary"></i>
                                            {{ \Carbon\Carbon::parse($fixture->match_date)->format('H:i') }}
                                        </div>
                                        <div class="venue-text text-truncate text-muted" title="{{ $fixture->venue ?? 'TBD' }}">
                                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                            {{ $fixture->venue ?? 'TBD' }}
                                        </div>
                                    </div>
                                @else
                                    <div class="score-container d-flex justify-content-center align-items-center">
                                        <span class="score-number text-primary" id="home-score-{{ $fixture->id }}">{{ $fixture->home_score ?? 0 }}</span> 
                                        <span class="vs-divider mx-2">VS</span> 
                                        <span class="score-number text-primary" id="away-score-{{ $fixture->id }}">{{ $fixture->away_score ?? 0 }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="text-center w-35 team-container">
                                <h5 class="fw-bold text-uppercase text-truncate team-name mb-0" title="{{ $fixture->awayTeam->name ?? 'TBD' }}">
                                    {{ $fixture->awayTeam->name ?? 'TBD' }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-x display-4 mb-2"></i>
                <p class="fs-5 mb-0">No upcoming fixtures scheduled at the moment.</p>
            </div>
        @endforelse

        <!-- Fallback empty container if a selected category contains no matches -->
        <div class="text-center py-5 text-muted d-none" id="category-empty-state">
            <i class="bi bi-folder-x display-4 mb-2"></i>
            <p class="fs-5 mb-0">No upcoming fixtures found for this category.</p>
        </div>
    </div>
</div>

<script>
    // Client-side filtering implementation
    document.querySelectorAll('.custom-filter-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Manage active styles across options
            document.querySelectorAll('.custom-filter-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const selectedFilter = this.getAttribute('data-filter');
            let visibleMatches = 0;

            document.querySelectorAll('.fixture-item').forEach(item => {
                if (selectedFilter === 'all' || item.getAttribute('data-sport') === selectedFilter) {
                    item.style.setProperty('display', 'block', 'important');
                    visibleMatches++;
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });

            // Toggle category empty feedback if count resolves to 0
            const emptyState = document.getElementById('category-empty-state');
            if (visibleMatches === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        });
    });

    // Real-time updates handler
    setInterval(function() {
        fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            document.querySelectorAll('[id^="center-container-"]').forEach(container => {
                const id = container.id.replace('center-container-', '');
                const incomingContainer = doc.getElementById('center-container-' + id);
                
                if (incomingContainer) {
                    if (container.innerHTML.trim() !== incomingContainer.innerHTML.trim()) {
                        container.innerHTML = incomingContainer.innerHTML;
                        
                        const scoreBox = container.querySelector('.score-container');
                        if (scoreBox) {
                            triggerScoreAnimation(scoreBox);
                        }
                    }
                }
            });
        });
    }, 5000);

    function triggerScoreAnimation(element) {
        element.classList.add('score-updated');
        setTimeout(() => element.classList.remove('score-updated'), 1000);
    }
</script>

<style>
    .header-section h2 { letter-spacing: -1px; }
    .match-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }
    .match-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.07) !important;
        border-color: rgba(13, 110, 253, 0.2) !important;
    }
    .match-header { background: rgba(248, 249, 250, 0.9); border-bottom: 1px dashed #dee2e6; }
    .match-date { font-size: 0.8rem; }
    .team-name { font-size: 1.1rem; letter-spacing: 0.3px; color: #2b3035; }
    .scheduled-info-box { display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .vs-text { font-size: 0.95rem; font-weight: 900; letter-spacing: 1px; }
    .match-time { font-size: 0.9rem; }
    .venue-text { font-size: 0.75rem; max-width: 140px; font-weight: 500; }
    .score-container { background: #f1f3f5; border-radius: 8px; padding: 4px 14px; box-shadow: inset 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #e9ecef; }
    .score-number { font-size: 1.7rem; font-weight: 800; line-height: 1; }
    .vs-divider { font-size: 0.9rem; color: #adb5bd; font-weight: 700; }
    .live-badge { animation: pulse-red 2s infinite; }
    
    @keyframes pulse-red {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1.03); box-shadow: 0 0 0 5px rgba(220, 53, 69, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    
    /* Filter Pill Button Styling */
    .custom-filter-btn { color: #6c757d; background-color: #f8f9fa; border: 1px solid #dee2e6; transition: all 0.3s ease; }
    .custom-filter-btn.active { background-color: var(--bs-primary) !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25); border-color: var(--bs-primary) !important; }
    .custom-filter-btn:hover:not(.active) { background-color: #e9ecef; color: #2b3035; }

    .score-updated { animation: flash-score 1s ease-out; }
    @keyframes flash-score {
        0% { background-color: #d1e7dd; transform: scale(1.05); }
        100% { background-color: #f1f3f5; transform: scale(1); }
    }
    .card-enter { opacity: 0; transform: translateY(10px); animation: fadeInUp 0.4s ease-out forwards; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
@endsection