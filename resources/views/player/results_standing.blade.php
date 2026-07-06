@extends('layout.navbar_only')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">League Standings & Results</h2>
    
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="leagueTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="standings-tab" data-bs-toggle="tab" data-bs-target="#standings-pane" type="button" role="tab" aria-controls="standings-pane" aria-selected="true">
                Standings
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="results-tab" data-bs-toggle="tab" data-bs-target="#results-pane" type="button" role="tab" aria-controls="results-pane" aria-selected="false">
                Recent Results
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="leagueTabContent">
        
        <!-- Standings Tab Pane -->
        <div class="tab-pane fade show active" id="standings-pane" role="tabpanel" aria-labelledby="standings-tab" tabindex="0">
            <div class="card border-0 shadow-sm p-4">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Team</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($standings as $index => $team)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $team->name }}</td>
                            <td><strong>{{ $team->points }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Results Tab Pane -->
        <div class="tab-pane fade" id="results-pane" role="tabpanel" aria-labelledby="results-tab" tabindex="0">
            <div class="card border-0 shadow-sm p-4">
                @if($results->isEmpty())
                    <p class="text-muted text-center mb-0">No recent results available.</p>
                @else
                    @foreach($results as $match)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="fs-5">{{ $match->home_team }} <span class="text-muted mx-2">vs</span> {{ $match->away_team }}</span>
                        <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">{{ $match->home_score }} - {{ $match->away_score }}</span>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        
    </div>
</div>
@endsection