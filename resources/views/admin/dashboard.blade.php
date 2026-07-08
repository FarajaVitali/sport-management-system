<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Organizer Dashboard</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --brand:         #2563eb;
            --brand-light:   #f0f7ff;
            --page-bg:       #fcfcfd; 
            --surface:       #ffffff;
            --border:        #eceef2; 
            --text-primary:  #1e293b;
            --text-muted:    #94a3b8;
            --font-display: 'Bebas Neue', sans-serif;
            --font-body:    'DM Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: var(--page-bg);
            background-image: 
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.03), transparent),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.03), transparent);
            font-family: var(--font-body);
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .portal {
            width: 100%;
            max-width: 880px;
            animation: fadeUp 0.55s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .portal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }
        .portal-brand { display: flex; align-items: center; gap: 14px; }
        .brand-logo {
            width: 50px; height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            flex-shrink: 0;
        }
        .brand-name {
            font-family: var(--font-display);
            font-size: 1.65rem; letter-spacing: 2.5px;
            color: var(--text-primary); line-height: 1;
        }
        .brand-tagline {
            font-size: 0.68rem; color: var(--text-muted);
            letter-spacing: 1.8px; text-transform: uppercase; margin-top: 3px;
        }
        .portal-greeting { text-align: right; }
        .portal-greeting .label {
            font-size: 0.7rem; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 1.2px;
        }
        .portal-greeting .name { font-size: 1.05rem; font-weight: 600; color: var(--brand); }

        /* Dashboard Panel */
        .dashboard-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
        }

        .panel-heading {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.75rem;
        }
        .panel-title {
            font-family: var(--font-display);
            font-size: 1.55rem; letter-spacing: 2px; color: var(--text-primary);
        }
        .panel-title span { color: var(--brand); }
        .panel-badge {
            font-size: 0.68rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; background: var(--brand-light); color: var(--brand);
            padding: 4px 12px; border-radius: 20px;
        }

        /* Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        @media (max-width: 600px) {
            .cards-grid { grid-template-columns: repeat(2, 1fr); }
            .portal-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .portal-greeting { text-align: left; }
        }

        /* Card Styles */
        .dash-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.5rem 1rem 1.3rem;
            text-align: center;
            cursor: pointer;
            text-decoration: none !important;
            color: var(--text-primary) !important;
            display: block;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dash-card:hover {
            transform: translateY(-4px);
            border-color: var(--c-accent); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.04);
        }

        .card-icon-wrap {
            width: 50px; height: 50px; border-radius: 14px;
            margin: 0 auto 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
        }

        /* Color Variations */
        .c-profile   { --c-accent:#2563eb; }
        .c-coaches   { --c-accent:#0891b2; }
        .c-schedule  { --c-accent:#059669; }
        .c-rules     { --c-accent:#d97706; }
        .c-live      { --c-accent:#7c3aed; } /* Purple for Live */
        .c-logout    { --c-accent:#dc2626; }

        .icon-profile   { background: #eff6ff; color: #2563eb; }
        .icon-coaches   { background: #ecfeff; color: #0891b2; }
        .icon-schedule  { background: #ecfdf5; color: #059669; }
        .icon-rules     { background: #fffbeb; color: #d97706; }
        .icon-live      { background: #f5f3ff; color: #7c3aed; }
        .icon-logout    { background: #fef2f2; color: #dc2626; }

        .card-label { font-size: 0.9rem; font-weight: 600; margin-bottom: 2px; }
        .card-sub   { font-size: 0.65rem; color: var(--text-muted); letter-spacing: 0.5px; text-transform: uppercase; }

        .portal-footer {
            margin-top: 2rem; text-align: center;
            font-size: 0.7rem; color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="portal">

    <div class="portal-header">
        <div class="portal-brand">
            <div class="brand-logo"><i class="bi bi-trophy-fill"></i></div>
            <div>
                <div class="brand-name">SHIMIVUTA</div>
                <div class="brand-tagline">Sports Portal</div>
            </div>
        </div>
        <div class="portal-greeting">
            <div class="label">Welcome</div>
            <div class="name">{{ auth()->user()->fname }}</div>
        </div>
    </div>

    <div class="dashboard-panel">
        <div class="panel-heading">
            <div class="panel-title">Organizer <span>Dashboard</span></div>
            <div class="panel-badge">Season 2025</div>
        </div>

        <div class="cards-grid">

            <a href="{{ route('admin.players') }}" class="dash-card c-profile">
                <div class="card-icon-wrap icon-profile"><i class="bi bi-person-lines-fill"></i></div>
                <div class="card-label">Manage Players</div>
                <div class="card-sub">Rosters & Approval</div>
            </a>

            <a href="{{ route('admin.coaches') }}" class="dash-card c-coaches">
                <div class="card-icon-wrap icon-coaches"><i class="bi bi-people-fill"></i></div>
                <div class="card-label">Manage Coaches</div>
                <div class="card-sub">Profiles & Teams</div>
            </a>

            <a href="{{ route('admin.management') }}" class="dash-card c-schedule">
                <div class="card-icon-wrap icon-schedule"><i class="bi bi-bank"></i></div>
                <div class="card-label">League Structure</div>
                <div class="card-sub">Colleges & Teams</div>
            </a>

            <a href="{{ route('admin.rules')}}" class="dash-card c-rules">
                <div class="card-icon-wrap icon-rules"><i class="bi bi-journal-text"></i></div>
                <div class="card-label">Tournament Rules</div>
                <div class="card-sub">Guidelines & Policies</div>
            </a>

            <a href="{{ route('admin.view_fixtures') }}" class="dash-card c-live">
                <div class="card-icon-wrap icon-live"><i class="bi bi-broadcast"></i></div>
                <div class="card-label">Live Match Control</div>
                <div class="card-sub">Scores & Timers</div>
            </a>

            <div class="dash-card c-logout" onclick="document.getElementById('logout-form').submit();">
                <div class="card-icon-wrap icon-logout"><i class="bi bi-box-arrow-right"></i></div>
                <div class="card-label">Logout</div>
                <div class="card-sub">End Session</div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>

        </div>
    </div>

    <div class="portal-footer">© 2025 Shimivuta Sports · Sports Management Excellence</div>

</div>

 <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</html>