<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Players</title>
    
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        /* The only custom utilities needed that aren't native to BS5 */
        .fs-7 { font-size: 0.85rem; }
        .tracking-wider { letter-spacing: 0.05em; }
    </style>
</head>
<body class="bg-light p-4">

    <div class="container-fluid px-4 py-3">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('coach.dashboard') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Dashboard
                </a>
                <div>
                    <h4 class="mb-1 text-dark fw-bold">Manage Squad</h4>
                    <p class="text-muted small mb-0">Manage and review all player accounts and profile assignments.</p>
                </div>
            </div>
            
            <div class="badge bg-primary px-3 py-2 fs-6">
                Total Players: {{ count($players) }}
            </div>
        </div>

        @php
            $gkCount = 0; $defCount = 0; $midCount = 0; $fwdCount = 0; $unassignedCount = 0;
            foreach($players as $p) {
                $pos = $p->playerProfile->position ?? 'Unassigned';
                if($pos == 'Goalkeeper') $gkCount++;
                elseif($pos == 'Defender') $defCount++;
                elseif($pos == 'Midfielder') $midCount++;
                elseif($pos == 'Forward') $fwdCount++;
                else $unassignedCount++;
            }
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-person-bounding-box fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Goalkeepers</div>
                            <div class="fs-5 fw-bold text-dark mb-0">{{ $gkCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-shield-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Defenders</div>
                            <div class="fs-5 fw-bold text-dark mb-0">{{ $defCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="bg-success-subtle text-success-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-bullseye fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Midfielders</div>
                            <div class="fs-5 fw-bold text-dark mb-0">{{ $midCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="bg-danger-subtle text-danger-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-lightning-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Forwards</div>
                            <div class="fs-5 fw-bold text-dark mb-0">{{ $fwdCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="bg-secondary-subtle text-secondary-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-question-lg fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Unassigned</div>
                            <div class="fs-5 fw-bold text-dark mb-0">{{ $unassignedCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom text-uppercase fs-7 tracking-wider">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold">Player Name</th>
                            <th class="py-3 text-muted fw-semibold">Jersey & Position</th>
                            <th class="py-3 text-muted fw-semibold text-center">Status</th>
                            <th class="py-3 text-muted fw-semibold text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr class="border-bottom-0">
                                <td class="ps-4 fw-semibold text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($player->fname, 0, 1)) }}
                                        </div>
                                        <div>{{ $player->fname }} {{ $player->lname }}</div>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark border px-2 py-1.5 fw-medium">
                                            #{{ $player->playerProfile->jersey_number ?? '00' }}
                                        </span>
                                        <span class="text-secondary">{{ $player->playerProfile->position ?? 'Unassigned' }}</span>
                                    </div>
                                </td>

                                <td class="text-center">
                                    @php $status = $player->playerProfile->physical_status ?? 'Fit'; @endphp
                                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold
                                        @if($status == 'Fit') bg-success-subtle text-success border border-success-subtle
                                        @elseif($status == 'Injured') bg-danger-subtle text-danger border border-danger-subtle
                                        @elseif($status == 'Suspended') bg-dark-subtle text-dark border border-dark-subtle
                                        @else bg-warning-subtle text-warning-emphasis border border-warning-subtle
                                        @endif">
                                        {{ $status }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-light text-dark border border-secondary-subtle d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#managePlayer{{ $player->id }}">
                                        <i class="bi bi-sliders me-1"></i> Manage
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="managePlayer{{ $player->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header bg-light border-bottom-0 rounded-top-4 py-3">
                                            <h5 class="modal-title fw-bold text-dark fs-5">
                                                <i class="bi bi-person-lines-fill me-2 text-primary"></i> 
                                                Manage {{ $player->fname }} {{ $player->lname }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="{{ route('coach.player.update', $player->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <h6 class="text-uppercase fs-7 tracking-wider text-muted fw-semibold mb-3 border-bottom pb-2">Tactics & Availability</h6>
                                                <div class="row g-3 mb-4">
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted fw-medium">Jersey No.</label>
                                                        <input type="number" name="jersey_number" class="form-control bg-light" 
                                                            value="{{ $player->playerProfile->jersey_number ?? '' }}" min="1" max="99">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted fw-medium">Position</label>
                                                        <select name="position" class="form-select bg-light" required>
                                                            @php $pos = $player->playerProfile->position ?? ''; @endphp
                                                            <option value="Goalkeeper" {{ $pos == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                                                            <option value="Defender" {{ $pos == 'Defender' ? 'selected' : '' }}>Defender</option>
                                                            <option value="Midfielder" {{ $pos == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                                                            <option value="Forward" {{ $pos == 'Forward' ? 'selected' : '' }}>Forward</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted fw-medium">Status</label>
                                                        <select name="physical_status" class="form-select bg-light" required>
                                                            @php $status = $player->playerProfile->physical_status ?? 'Fit'; @endphp
                                                            <option value="Fit" {{ $status == 'Fit' ? 'selected' : '' }}>Fit</option>
                                                            <option value="Benched" {{ $status == 'Benched' ? 'selected' : '' }}>Benched</option>
                                                            <option value="Injured" {{ $status == 'Injured' ? 'selected' : '' }}>Injured</option>
                                                            <option value="Suspended" {{ $status == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <h6 class="text-uppercase fs-7 tracking-wider text-muted fw-semibold mb-3 border-bottom pb-2 mt-4">Season Statistics</h6>
                                                <div class="row g-3">
                                                    <div class="col-6 col-md-3">
                                                        <label class="form-label small text-muted fw-medium"><i class="bi bi-bullseye me-1 text-success"></i> Goals</label>
                                                        <input type="number" name="goals" class="form-control bg-light" value="{{ $player->playerProfile->goals ?? 0 }}" min="0">
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <label class="form-label small text-muted fw-medium"><i class="bi bi-people me-1 text-info"></i> Assists</label>
                                                        <input type="number" name="assists" class="form-control bg-light" value="{{ $player->playerProfile->assists ?? 0 }}" min="0">
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <label class="form-label small text-muted fw-medium"><i class="bi bi-file-fill me-1 text-warning"></i> Yellows</label>
                                                        <input type="number" name="yellow_cards" class="form-control bg-light" value="{{ $player->playerProfile->yellow_cards ?? 0 }}" min="0">
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <label class="form-label small text-muted fw-medium"><i class="bi bi-file-fill me-1 text-danger"></i> Reds</label>
                                                        <input type="number" name="red_cards" class="form-control bg-light" value="{{ $player->playerProfile->red_cards ?? 0 }}" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-top-0 rounded-bottom-4 py-3">
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-primary px-4">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>