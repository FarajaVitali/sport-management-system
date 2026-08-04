@extends('layout.navbar_only')

@section('title', 'Tournament Standings & Results')

@section('content')
<div class="container py-5">
    <div class="mb-4 text-center">
        <h3 class="fw-bold text-dark">Tournament Standings & Results</h3>
        <p class="text-muted">Select a sport tab below to view divisions, live standings, and recent results.</p>
    </div>

    @if($sports->count() > 0)
        <!-- SPORT TABS NAVIGATION -->
        <ul class="nav nav-pills justify-content-center mb-5 gap-2" id="sportTabs" role="tablist">
            @foreach($sports as $index => $sport)
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-2 rounded-pill fw-semibold {{ $index === 0 ? 'active' : '' }}" 
                            id="sport-{{ $sport->id }}-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#sport-{{ $sport->id }}" 
                            type="button" 
                            role="tab" 
                            aria-controls="sport-{{ $sport->id }}" 
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        {{ $sport->name }}
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- SPORT TABS CONTENT -->
        <div class="tab-content" id="sportTabsContent">
            @foreach($sports as $index => $sport)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                     id="sport-{{ $sport->id }}" 
                     role="tabpanel" 
                     aria-labelledby="sport-{{ $sport->id }}-tab">
                    
                    <div class="row g-4">
                        <!-- Loop through genders (Men & Women) -->
                        @foreach(['men', 'women'] as $gender)
                            @if(isset($standings[$sport->id][$gender]) && $standings[$sport->id][$gender]->count() > 0)
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                    <div class="card-header bg-dark text-white text-center py-3">
                                        <h5 class="mb-0 text-capitalize">{{ $gender }}'s Division</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0 text-center">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="py-3 text-start px-4">Team</th>
                                                    <th class="py-3" title="Matches Played">P</th>
                                                    <th class="py-3" title="Goal Difference">GD</th>
                                                    <th class="py-3 fw-bold text-warning" title="Total Points">PTS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sortedTeams = $standings[$sport->id][$gender]->sortByDesc('points')->sortByDesc(function($t) {
                                                        return ($t->goals_for ?? 0) - ($t->goals_against ?? 0);
                                                    });
                                                @endphp
                                                
                                                @foreach($sortedTeams as $team)
                                                <tr>
                                                    <td class="text-start px-4 fw-semibold">{{ $team->name }}</td>
                                                    <td>{{ $team->played ?? 0 }}</td>
                                                    <td class="{{ (($team->goals_for ?? 0) - ($team->goals_against ?? 0)) > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ ($team->goals_for ?? 0) - ($team->goals_against ?? 0) }}
                                                    </td>
                                                    <td class="fw-bold fs-5 text-primary">{{ $team->points ?? 0 }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- RECENT RESULTS SECTION FOR THIS SPORT -->
                    @if(isset($results[$sport->id]) && $results[$sport->id]->count() > 0)
                        <div class="mt-5">
                            <h5 class="fw-bold text-secondary mb-3 border-bottom pb-2">Recent Completed Matches</h5>
                            <div class="row g-3">
                                @foreach($results[$sport->id] as $genderGroup)
                                    @foreach($genderGroup as $fixture)
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm rounded-3 p-3 text-center">
                                            <span class="badge bg-light text-secondary border mb-2 text-capitalize">{{ $fixture->homeTeam->gender ?? 'Match' }} Division</span>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-semibold text-start text-truncate" style="max-width: 35%;">{{ $fixture->homeTeam->name ?? 'TBD' }}</span>
                                                <span class="badge bg-dark fs-6 px-3 py-2">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                                                <span class="fw-semibold text-end text-truncate" style="max-width: 35%;">{{ $fixture->awayTeam->name ?? 'TBD' }}</span>
                                            </div>
                                            <small class="text-muted mt-2"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($fixture->match_date)->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-shield-x fs-1 text-muted"></i>
            <p class="text-muted mt-3">No sports or standings available yet.</p>
        </div>
    @endif
</div>
@endsection