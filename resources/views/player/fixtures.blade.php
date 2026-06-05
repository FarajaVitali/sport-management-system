@extends('layout.navbar_only')

@section('title', 'League Match Calendar')

@section('content')
<div class="container py-4">
    
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-calendar-event text-primary me-2"></i>Tournament Match Calendar</h4>
        <p class="text-muted small mb-0">Track official up-to-date timelines, match assignments, and match weeks for all structural disciplines.</p>
    </div>

    @if($fixturesBySport->isEmpty())
        <div class="card border-0 shadow-sm text-center py-5 rounded-3">
            <div class="card-body">
                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                <h6 class="fw-bold text-dark">No Fixtures Released Yet</h6>
                <p class="text-muted small mb-0">The coordination organizers haven't generated the competitive matrices for this season yet.</p>
            </div>
        </div>
    @else
        <ul class="nav nav-pills mb-4 bg-white p-2 rounded-3 shadow-sm gap-2" id="sportTab" role="tablist">
            @foreach($fixturesBySport as $sportName => $rounds)
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-capitalize fw-semibold px-4 py-2 rounded-3 {{ $loop->first ? 'active' : '' }}" 
                            id="tab-{{ Str::slug($sportName) }}" 
                            data-bs-toggle="tab" 
                            data-bs-target="#pane-{{ Str::slug($sportName) }}" 
                            type="button" 
                            role="tab">
                        {{ $sportName }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="sportTabContent">
            @foreach($fixturesBySport as $sportName => $rounds)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                     id="pane-{{ Str::slug($sportName) }}" 
                     role="tabpanel">
                     
                     <div class="row g-4">
                         @foreach($rounds as $roundNumber => $games)
                             <div class="col-md-12">
                                 <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                     <div class="card-header bg-dark text-white py-2.5 px-4 d-flex justify-content-between align-items-center">
                                         <span class="fw-bold small tracking-wide"><i class="bi bi-flag-fill text-warning me-2"></i>ROUND MATCH WEEK {{ $roundNumber }}</span>
                                         <span class="badge bg-secondary text-uppercase small" style="font-size: 0.7rem;">
                                             {{ $games->first()->match_date ? \Carbon\Carbon::parse($games->first()->match_date)->format('M d, Y') : 'Date TBD' }}
                                         </span>
                                     </div>
                                     
                                     <div class="list-group list-group-flush">
                                         @foreach($games as $game)
                                             <div class="list-group-item py-3.5 px-4">
                                                 
                                                 <div class="d-flex align-items-center justify-content-between">
                                                     
                                                     <div class="text-end fw-bold text-dark fs-6" style="width: 42%;">
                                                         {{ $game->homeTeam->name }}
                                                         <i class="bi bi-house-door text-muted ms-2 small" title="Home Court/Field"></i>
                                                     </div>
                                                     
                                                     <div class="text-center">
                                                         <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fw-bold font-monospace shadow-sm">
                                                             VS
                                                         </span>
                                                         <small class="d-block text-muted text-uppercase tracking-wider mt-1" style="font-size: 0.65rem;">
                                                             {{ $game->status }}
                                                         </small>
                                                     </div>
                                                     
                                                     <div class="text-start fw-bold text-dark fs-6" style="width: 42%;">
                                                         <i class="bi bi-geo text-muted me-2 small" title="Away Court/Field"></i>
                                                         {{ $game->awayTeam->name }}
                                                     </div>

                                                 </div>

                                                 <div class="d-flex justify-content-center gap-4 mt-2 pt-2 border-top border-light small text-muted font-monospace">
                                                     <span>
                                                         <i class="bi bi-clock text-primary me-1"></i> 
                                                         {{ $game->match_date ? \Carbon\Carbon::parse($game->match_date)->format('h:i A') : 'TBD' }}
                                                     </span>
                                                     <span>
                                                         <i class="bi bi-geo-alt-fill text-danger me-1"></i> 
                                                         {{ $game->venue ?? 'Venue Unassigned' }}
                                                     </span>
                                                 </div>

                                             </div>
                                         @endforeach
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                     
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection