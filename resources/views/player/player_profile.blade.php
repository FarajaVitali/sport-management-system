<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <title>Player Dashboard</title>
    <style>
        .player-badge {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }
        .metric-label {
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    
                    <div class="card-header bg-dark text-white p-4 border-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="player-badge bg-primary text-white rounded-circle shadow-sm">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1 tracking-tight">{{ $user->fname }} {{ $user->lname }}</h4>
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold border border-success-subtle" style="font-size: 0.7rem;">
                                    <i class="bi bi-check-circle-fill me-1"></i>Active Athlete
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 bg-white">
                        
                        <div class="row text-center g-3 mb-4">
                            <div class="col-4">
                                <div class="p-2.5 bg-light rounded-3 border border-light-subtle">
                                    <span class="text-uppercase text-muted fw-bold metric-label d-block mb-1">Squad Team</span>
                                    <span class="fw-bold text-dark text-truncate d-block" style="font-size: 0.9rem;">
                                        {{ $user->playerProfile->team ?? 'Not Set' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2.5 bg-light rounded-3 border border-light-subtle">
                                    <span class="text-uppercase text-muted fw-bold metric-label d-block mb-1">Jersey</span>
                                    <span class="fw-bold text-primary d-block" style="font-size: 0.9rem;">
                                        {{ $user->playerProfile->jersey_number ? '#'.$user->playerProfile->jersey_number : '--' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2.5 bg-light rounded-3 border border-light-subtle">
                                    <span class="text-uppercase text-muted fw-bold metric-label d-block mb-1">Position</span>
                                    <span class="fw-bold text-dark text-truncate d-block" style="font-size: 0.9rem;">
                                        {{ $user->playerProfile->position ?? 'Not Set' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="list-group list-group-flush border-top border-bottom border-light mb-4">
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center bg-transparent">
                                <span class="text-muted small"><i class="bi bi-envelope me-2"></i>Email Address</span>
                                <span class="fw-medium text-dark">{{ $user->email }}</span>
                            </div>
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center bg-transparent">
                                <span class="text-muted small"><i class="bi bi-building me-2"></i>Institution / College</span>
                                <span class="fw-medium text-dark">{{ $user->playerProfile->college->name ?? 'Unassigned' }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('player.profile') }}" class="btn btn-light border fw-semibold btn-sm px-3 py-2 rounded-3 text-secondary">
                                <i class="bi bi-gear-fill me-1.5"></i>Account Settings
                            </a>
                            <a href="{{ route('player.profile') }}" class="btn btn-primary fw-semibold btn-sm px-4 py-2 rounded-3 shadow-sm">
                                <i class="bi bi-pencil-square me-1.5"></i>Edit Profile
                            </a>
                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                    <h6 class="fw-bold text-dark mb-3 px-1"><i class="bi bi-grid-fill text-primary me-2"></i>Athlete Action Hub</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('player.fixtures') }}" class="btn btn-outline-dark w-100 text-start p-3 rounded-3 d-flex align-items-center gap-3 transition-all">
                                <div class="bg-primary-subtle text-primary p-2 rounded-3">
                                    <i class="bi bi-calendar3 fs-5 d-block"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block small text-dark">Match Fixtures</span>
                                    <small class="text-muted font-monospace" style="font-size: 0.65rem;">View Schedules</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('player.form') }}" class="btn btn-outline-dark w-100 text-start p-3 rounded-3 d-flex align-items-center gap-3 transition-all">
                                <div class="bg-warning-subtle text-warning-dominant p-2 rounded-3">
                                    <i class="bi bi-file-earmark-text text-warning fs-5 d-block"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block small text-dark">Roster Form</span>
                                    <small class="text-muted font-monospace" style="font-size: 0.65rem;">Update Status</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>