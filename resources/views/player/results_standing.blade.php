@extends('layout.navbar_only')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">League Standings & Results</h2>

    <!-- Sport Tabs -->
    <ul class="nav nav-pills mb-4 gap-2" id="sportTab" role="tablist">
        @foreach($sports as $index => $sport)
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold {{ $index == 0 ? 'active' : '' }}"
                    id="sport-tab-{{ $sport->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#sport-pane-{{ $sport->id }}"
                    type="button" role="tab">
                    {{ $sport->name }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="sportTabContent">
        @foreach($sports as $sportIndex => $sport)
        <div class="tab-pane fade {{ $sportIndex == 0 ? 'show active' : '' }}" id="sport-pane-{{ $sport->id }}" role="tabpanel">

            <!-- Gender Sub-Tabs -->
            <ul class="nav nav-tabs mb-3" id="genderTab-{{ $sport->id }}" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#men-{{ $sport->id }}" type="button" role="tab">
                        Men's Division
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#women-{{ $sport->id }}" type="button" role="tab">
                        Women's Division
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                @foreach(['men' => 'Men', 'women' => 'Women'] as $genderKey => $genderLabel)
                <div class="tab-pane fade {{ $genderKey === 'men' ? 'show active' : '' }}" id="{{ $genderKey }}-{{ $sport->id }}" role="tabpanel">

                    @php
                        $group = $standings->get($sport->id, collect())->get($genderKey, collect());
                    @endphp

                    <div class="card border-0 shadow-sm p-4 mb-4">
                        <h6 class="fw-bold text-secondary text-uppercase small mb-3">{{ $sport->name }} — {{ $genderLabel }} Standings</h6>

                        @if($group->isEmpty())
                            <p class="text-muted text-center mb-0 py-3">No teams in this division yet.</p>
                        @else
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Team</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($group->sortByDesc('points')->values() as $index => $team)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $team->name }}</td>
                                        <td><strong>{{ $team->points }}</strong></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    @php
                        $resultGroup = $results->get($sport->id, collect())->get($genderKey, collect());
                    @endphp

                    <div class="card border-0 shadow-sm p-4">
                        <h6 class="fw-bold text-secondary text-uppercase small mb-3">Recent {{ $genderLabel }} Results</h6>

                        @if($resultGroup->isEmpty())
                            <p class="text-muted text-center mb-0 py-3">No recent results available.</p>
                        @else
                            @foreach($resultGroup as $match)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <span class="fs-6">{{ $match->homeTeam->name ?? 'TBD' }} <span class="text-muted mx-2">vs</span> {{ $match->awayTeam->name ?? 'TBD' }}</span>
                                <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">{{ $match->home_score }} - {{ $match->away_score }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>

                </div>
                @endforeach
            </div>

        </div>
        @endforeach
    </div>
</div>
@endsection