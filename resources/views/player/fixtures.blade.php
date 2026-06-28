@extends('layout.navbar_only')

@section('title', 'Match Schedule')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="text-center mb-5 header-section">
        <h2 class="fw-bolder text-dark display-6 mb-2">Tournament Matches</h2>
        <p class="text-muted fs-5">Real-time updates for all scheduled fixtures</p>
    </div>

    <div class="row g-4 justify-content-center" id="fixtures-container">
        @foreach($fixtures as $index => $fixture)
        
        <div class="col-12 col-lg-6 card-enter" style="animation-delay: {{ $index * 0.1 }}s" id="fixture-{{ $fixture->id }}">
            <div class="card border-0 rounded-4 h-100 overflow-hidden match-card">
                
                <div class="px-4 py-3 d-flex justify-content-between align-items-center match-header">
                    <span class="badge {{ $fixture->status == 'live' ? 'bg-danger live-badge' : ($fixture->status == 'completed' ? 'bg-success' : 'bg-secondary') }}">
                        {{ strtoupper($fixture->status) }}
                    </span>
                    <small class="text-muted fw-bold match-date">
                        <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($fixture->match_date)->format('M d, H:i') }}
                    </small>
                </div>

                <div class="card-body p-4 p-md-5"> <div class="d-flex justify-content-between align-items-center">
                        
                        <div class="text-center w-35 team-container">
                            <h5 class="fw-bold text-uppercase text-truncate team-name mb-0" title="{{ $fixture->homeTeam->name ?? 'TBD' }}">
                                {{ $fixture->homeTeam->name ?? 'TBD' }}
                            </h5>
                        </div>

                        <div class="text-center px-4 w-30">
                            <div class="score-container d-flex justify-content-center align-items-center">
                                <span class="score-number text-primary" id="home-score-{{ $fixture->id }}">{{ $fixture->home_score ?? 0 }}</span> 
                                <span class="vs-divider mx-3">VS</span> 
                                <span class="score-number text-primary" id="away-score-{{ $fixture->id }}">{{ $fixture->away_score ?? 0 }}</span>
                            </div>
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
        @endforeach
    </div>
</div>

<script>
    // Live update logic
    setInterval(function() {
        fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            document.querySelectorAll('[id^="fixture-"]').forEach(card => {
                const id = card.id.replace('fixture-', '');
                const newHomeScore = doc.getElementById('home-score-' + id)?.innerText;
                const newAwayScore = doc.getElementById('away-score-' + id)?.innerText;
                
                if (newHomeScore !== undefined) {
                    const homeEl = document.getElementById('home-score-' + id);
                    const awayEl = document.getElementById('away-score-' + id);
                    
                    if(homeEl.innerText !== newHomeScore) {
                        homeEl.innerText = newHomeScore;
                        triggerScoreAnimation(homeEl);
                    }
                    if(awayEl.innerText !== newAwayScore) {
                        awayEl.innerText = newAwayScore;
                        triggerScoreAnimation(awayEl);
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
    /* Overall Page Typography */
    .header-section h2 {
        letter-spacing: -1px;
    }

    /* Professional Card Effects */
    .match-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }
    
    .match-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        border-color: rgba(13, 110, 253, 0.2) !important;
    }

    /* Header & Date Styling */
    .match-header {
        background: rgba(248, 249, 250, 0.9);
        border-bottom: 1px dashed #dee2e6;
    }
    .match-date {
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    /* Team Name Styling */
    .team-name {
        font-size: 1.25rem; /* Increased font size for wider cards */
        letter-spacing: 0.5px;
        color: #2b3035;
    }

    /* Scoreboard Container */
    .score-container {
        background: #f1f3f5;
        border-radius: 12px;
        padding: 12px 20px; /* Slightly larger padding */
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
    }

    .score-number {
        font-size: 2.2rem; /* Slightly larger numbers */
        font-weight: 800;
        line-height: 1;
        transition: color 0.3s ease;
    }

    .vs-divider {
        font-size: 1.1rem;
        color: #adb5bd;
        font-weight: 700;
    }

    /* Live Pulse Animation */
    .live-badge {
        animation: pulse-red 2s infinite;
        letter-spacing: 1px;
    }
    
    @keyframes pulse-red {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    /* Score Update Flash Animation */
    .score-updated {
        animation: flash-score 1s ease-out;
    }
    
    @keyframes flash-score {
        0% { color: #198754; transform: scale(1.2); }
        100% { color: var(--bs-primary); transform: scale(1); }
    }

    /* Cascading Entrance Animation for Cards */
    .card-enter {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease-out forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection