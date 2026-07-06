@extends('layout.navbar_only')

@section('title', 'Match Arena Overview')

@section('content')
<div class="match-arena-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                
                <h6 class="timeline-header text-center mb-4">Match Board Timeline</h6>

                <!-- Live Score App Style Card -->
                <div class="livescore-card mx-auto mb-5">
                    
                    <!-- Left Section: Match Status & Time -->
                    <div class="livescore-status">
                        @if($fixture->status === 'live')
                            <div class="status-top text-danger">LIVE</div>
                            <div id="live-timer" class="status-bottom text-danger live-pulse">00:00</div>
                        @elseif($fixture->status === 'completed')
                            <div class="status-top text-muted">FT</div>
                            <div class="status-bottom"></div>
                        @else
                            <div class="status-top text-muted">Fixture</div>
                            <div class="status-bottom">-</div>
                        @endif
                    </div>

                    <!-- Vertical Divider -->
                    <div class="livescore-divider"></div>

                    <!-- Middle Section: Teams & Scores -->
                    <div class="livescore-details">
                        
                        <!-- Home Team Row -->
                        <div class="team-row mb-3">
                            <div class="team-logo">
                                <!-- Placeholder icon if you don't have team logos -->
                                <i class="bi bi-shield-shaded text-secondary"></i>
                            </div>
                            <div class="team-name" title="{{ $fixture->homeTeam->name }}">
                                {{ $fixture->homeTeam->name }}
                            </div>
                            <div class="team-score" id="home-score-display">
                                {{ $fixture->home_score }}
                            </div>
                        </div>

                        <!-- Away Team Row -->
                        <div class="team-row">
                            <div class="team-logo">
                                <!-- Placeholder icon if you don't have team logos -->
                                <i class="bi bi-shield-shaded text-secondary"></i>
                            </div>
                            <div class="team-name" title="{{ $fixture->awayTeam->name }}">
                                {{ $fixture->awayTeam->name }}
                            </div>
                            <div class="team-score" id="away-score-display">
                                {{ $fixture->away_score }}
                            </div>
                        </div>

                    </div>

                    <!-- Right Section: Action/Favorite Star -->
                    <div class="livescore-action">
                        <i class="bi bi-star"></i>
                    </div>

                </div>

                <div class="d-flex justify-content-center">
                    <a href="{{ route('admin.view_fixtures') }}" class="btn action-btn shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Return to Fixtures
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    @if($fixture->status === 'live' && $fixture->started_at)
        const startTime = new Date("{{ \Carbon\Carbon::parse($fixture->started_at)->toIso8601String() }}").getTime();
        
        const clockInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = now - startTime;
            
            if (distance < 0) {
                document.getElementById("live-timer").innerHTML = "00:00";
                return;
            }
            
            const minutes = Math.floor(distance / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            const timerContainer = document.getElementById("live-timer");
            if(timerContainer) {
                timerContainer.innerHTML = 
                    (minutes < 10 ? "0" : "") + minutes + ":" + 
                    (seconds < 10 ? "0" : "") + seconds;
            }
        }, 1000);
    @endif
</script>

<style>
    /* --- LIVESCORE LAYOUT STYLES --- */
    
    .match-arena-wrapper {
        background-color: #f8fafc;
        min-height: calc(100vh - 80px);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .timeline-header {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #64748b;
        font-weight: 700;
    }

    /* Main Card Container */
    .livescore-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 16px 20px;
        
        /* INCREASED WIDTH HERE */
        max-width: 700px; 
        width: 100%;
        
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Left Status Column */
    .livescore-status {
        width: 60px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-shrink: 0;
    }

    .status-top {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .status-bottom {
        font-size: 1rem;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .live-pulse {
        animation: opacity-pulse 1.5s infinite;
    }

    @keyframes opacity-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Vertical Divider */
    .livescore-divider {
        width: 1px;
        background-color: #e2e8f0;
        align-self: stretch;
        margin: 0 20px;
    }

    /* Middle Teams Column */
    .livescore-details {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
    }

    .team-row {
        display: flex;
        align-items: center;
    }

    .team-logo {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .team-name {
        font-size: 1.05rem;
        font-weight: 600;
        color: #0f172a;
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 15px;
    }

    .team-score {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        min-width: 25px;
        text-align: right;
    }

    /* Right Action/Star Column */
    .livescore-action {
        margin-left: 16px;
        color: #94a3b8;
        font-size: 1.2rem;
        cursor: pointer;
        transition: color 0.2s ease;
        display: flex;
        align-items: center;
    }

    .livescore-action:hover {
        color: #f59e0b;
    }

    /* Return Button */
    .action-btn {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background-color: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* Mobile Adjustments */
    @media (max-width: 576px) {
        .livescore-card { padding: 12px 16px; }
        .livescore-divider { margin: 0 16px; }
        .team-name { font-size: 1rem; }
    }
</style>
@endsection