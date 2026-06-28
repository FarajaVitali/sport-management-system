@extends('layout.navbar_only')

@section('title', 'Live Match Control')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            <h5 class="text-muted text-uppercase fw-bold mb-3">Live Match Control</h5>
            
            <div class="mb-4">
                <span id="live-timer" class="badge bg-danger fs-1 px-4 py-2 rounded-3 shadow-sm timer-blink">
                    00:00
                </span>
                <p class="text-muted small mt-2">Minutes : Seconds</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4 p-5 mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    
                    <div class="text-center w-25">
                        <h4 class="fw-bold">{{ $fixture->homeTeam->name }}</h4>
                        <h1 class="display-1 fw-bolder text-primary" id="home-score-display">{{ $fixture->home_score }}</h1>
                        @if($fixture->status === 'live')
                            <button onclick="addGoal('home')" class="btn btn-outline-primary btn-lg rounded-circle fw-bold fs-4" style="width: 60px; height: 60px;">+</button>
                        @endif
                    </div>

                    <div class="text-muted fw-bold fs-4">VS</div>

                    <div class="text-center w-25">
                        <h4 class="fw-bold">{{ $fixture->awayTeam->name }}</h4>
                        <h1 class="display-1 fw-bolder text-primary" id="away-score-display">{{ $fixture->away_score }}</h1>
                        @if($fixture->status === 'live')
                            <button onclick="addGoal('away')" class="btn btn-outline-primary btn-lg rounded-circle fw-bold fs-4" style="width: 60px; height: 60px;">+</button>
                        @endif
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                @if($fixture->status !== 'live')
                    <form action="{{ route('admin.match.start', $fixture->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm">
                            <i class="bi bi-play-circle me-2"></i> Kick Off
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.match.end', $fixture->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark btn-lg px-5 fw-bold shadow-sm">
                            <i class="bi bi-stop-circle me-2"></i> End Match
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // --- SCORE UPDATING LOGIC ---
    function addGoal(team) {
        fetch("{{ route('admin.add_goal', $fixture->id) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ team: team })
        })
        .then(response => response.json())
        .then(data => {
            // Update UI with new values returned from controller
            document.getElementById('home-score-display').innerText = data.home_score;
            document.getElementById('away-score-display').innerText = data.away_score;
        })
        .catch(error => console.error('Error:', error));
    }

    // --- TIMER LOGIC ---
    @if($fixture->status === 'live' && $fixture->started_at)
        const startTime = new Date("{{ \Carbon\Carbon::parse($fixture->started_at)->toIso8601String() }}").getTime();
        
        setInterval(function() {
            const now = new Date().getTime();
            const distance = now - startTime;
            
            const minutes = Math.floor(distance / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById("live-timer").innerHTML = 
                (minutes < 10 ? "0" : "") + minutes + ":" + 
                (seconds < 10 ? "0" : "") + seconds;
        }, 1000);
    @else
        console.log("Timer not started: Status is not live or started_at is missing.");
    @endif
</script>

<style>
    .timer-blink { animation: blinker 2s linear infinite; }
    @keyframes blinker { 50% { opacity: 0.8; } }
</style>
@endsection