@extends('layout.navbar_only') {{-- Kept so your system styles and icons still load properly --}}

@section('title', 'Coach Dashboard')

@section('content')
<style>
    /* Hides the default top navigation bar layout element safely on this specific view */
    .navbar, nav, [role="navigation"] {
        display: none !important;
    }

    /* Premium Design System Overrides */
    body {
        background-color: #f8fafc;
        color: #1e293b;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.05), 0 2px 4px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
        display: block;
        height: 100%;
    }
    
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -3px rgba(15, 23, 42, 0.08), 0 4px 8px -4px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    /* Team Banner Custom Theme */
    .team-status-banner {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #ffffff;
    }
</style>

<div class="container py-4 px-4">
    
    <div class="card border-0 rounded-4 team-status-banner p-4 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 mb-2 small text-uppercase tracking-wider fw-bold">
                    Official Head Coach
                </span>
                <h3 class="fw-bold mb-1">Welcome, {{ Auth::user()->fname ?? 'Coach' }}!</h3>
                <p class="text-slate-300 small mb-0 opacity-75">Manage team assignments, monitor scheduled match fixtures.</p>
            </div>
            
            <div class="bg-white bg-opacity-10 rounded-3 p-3 border border-white border-opacity-10 backdrop-blur">
                <div class="small text-uppercase tracking-wider text-muted text-white-50 fw-semibold">Assigned Roster</div>
                <div class="fw-bold fs-5 text-warning">
                    <i class="bi bi-shield-check me-1"></i> {{ Auth::user()->coachProfile->team->name ?? 'Unassigned (TBD)' }}
                </div>
                <div class="small text-white-50 mt-1">
                    <i class="bi bi-building me-1"></i> {{ Auth::user()->coachProfile->team->college->name ?? 'No Institution' }}
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('coach.players') }}" class="card dashboard-card rounded-4 p-4">
                <div class="icon-shape bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Team Players</h5>
                <p class="text-muted small mb-0">View your active player here.</p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('coach.fixtures') }}" class="card dashboard-card rounded-4 p-4">
                <div class="icon-shape bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-calendar3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Match Fixtures</h5>
                <p class="text-muted small mb-0">View games field, time, and logged results.</p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('rules.index') }}" class="card dashboard-card rounded-4 p-4">
                <div class="icon-shape bg-secondary-subtle text-dark border border-secondary-subtle">
                    <i class="bi bi-book-half"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Sport Rules</h5>
                <p class="text-muted small mb-0">Explore tournament guidelines, disciplinary and official game regulations.</p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('coach.profile') }}" class="card dashboard-card rounded-4 p-4">
                <div class="icon-shape bg-info-subtle text-info border border-info-subtle">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">View Coach Profile</h5>
                <p class="text-muted small mb-0">View your profiles info.</p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('coach.profile.edit') }}" class="card dashboard-card rounded-4 p-4">
                <div class="icon-shape bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="bi bi-sliders"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Modify Security Credentials</h5>
                <p class="text-muted small mb-0">Update account email change login passwords.</p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card dashboard-card rounded-4 p-4 border-danger-subtle bg-danger-subtle bg-opacity-10">
                <div class="icon-shape bg-danger-subtle text-danger border border-danger-subtle">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <h5 class="fw-bold text-danger mb-2">Log out</h5>
                <p class="text-muted small mb-3">Safely terminate your active session.</p>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger w-100 py-2 fw-semibold rounded-3">
                        Log Out Now
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection