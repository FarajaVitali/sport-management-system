@extends('layout.navbar_only')

@section('title', 'Match Schedule')

@section('content')
<div class="container-fluid px-4 py-5">
    
    <div class="text-center mb-4 header-section">
        <h2 class="fw-bolder text-dark display-6 mb-2">Tournament Matches</h2>
        <p class="text-muted fs-5">Real-time updates for the Shimivuta Sports League</p>
    </div>

    <ul class="nav nav-pills justify-content-center mb-5 gap-2" id="fixtureTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 py-2 rounded-pill custom-tab-btn" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-panes" type="button" role="tab">
                <i class="bi bi-calendar-event me-2"></i>Upcoming Fixtures ({{ $upcoming->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4 py-2 rounded-pill custom-tab-btn" id="results-tab" data-bs-toggle="tab" data-bs-target="#results-panes" type="button" role="tab">
                <i class="bi bi-trophy me-2"></i>Past Results ({{ $results->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="fixtureTabsContent">
        
        <div class="tab-pane fade show active" id="upcoming-panes" role="tabpanel">
            <div class="row g-3 d-flex flex-column align-items-center">
                @forelse($upcoming as $index => $fixture)
                    @include('partials.fixture_card', ['fixture' => $fixture, 'index' => $index])
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x display-4 mb-2"></i>
                        <p class="fs-5 mb-0">No upcoming fixtures scheduled at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="results-panes" role="tabpanel">
            <div class="row g-3 d-flex flex-column align-items-center">
                @forelse($results as $index => $fixture)
                    @include('partials.fixture_card', ['fixture' => $fixture, 'index' => $index])
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-clipboard-x display-4 mb-2"></i>
                        <p class="fs-5 mb-0">No match results available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<script>
    // Optimized Live real-time update engine logic
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
    /* Clean custom styling for interactive nav buttons */
    .custom-tab-btn {
        color: #6c757d;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    .custom-tab-btn.active {
        background-color: var(--bs-primary) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        border-color: var(--bs-primary) !important;
    }
    .custom-tab-btn:hover:not(.active) {
        background-color: #e9ecef;
        color: #2b3035;
    }
    .score-updated {
        animation: flash-score 1s ease-out;
    }
    @keyframes flash-score {
        0% { background-color: #d1e7dd; transform: scale(1.05); }
        100% { background-color: #f1f3f5; transform: scale(1); }
    }
</style>
@endsection