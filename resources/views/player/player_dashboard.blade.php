<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Player Dashboard</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --brand:         #2563eb;
            --brand-light:   #f0f7ff;
            --accent:        #10b981;
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

        /* ── Header ── */
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

        /* ── Main panel ── */
        .dashboard-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.2rem;
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.05), 
                0 10px 15px -3px rgba(0, 0, 0, 0.03);
            position: relative;
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

        /* ── Grid ── */
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

        /* ── Card ── */
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

        /* ── Icon ── */
        .card-icon-wrap {
            width: 50px; height: 50px; border-radius: 14px;
            margin: 0 auto 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
            transition: transform 0.22s ease;
        }

        .c-profile   { --c-accent:#2563eb; }
        .c-schedule  { --c-accent:#059669; }
        .c-standings { --c-accent:#0891b2; }
        .c-rules     { --c-accent:#d97706; }
        .c-settings  { --c-accent:#7c3aed; }
        .c-logout    { --c-accent:#dc2626; }

        .icon-profile   { background: #eff6ff; color: #2563eb; }
        .icon-schedule  { background: #ecfdf5; color: #059669; }
        .icon-standings { background: #ecfeff; color: #0891b2; }
        .icon-rules     { background: #fffbeb; color: #d97706; }
        .icon-settings  { background: #f5f3ff; color: #7c3aed; }
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
            <div class="label">Welcome Back</div>
            <div class="name">{{ $user->fname }}</div>
        </div>
    </div>

    <div class="dashboard-panel">
        <div class="panel-heading">
            <div class="panel-title">Player <span>Dashboard</span></div>
            <div class="panel-badge">Season 2025</div>
        </div>

        <div class="cards-grid">

            <a href="{{ route('player.profile') }}" class="dash-card c-profile">
                <div class="card-icon-wrap icon-profile"><i class="bi bi-person-circle"></i></div>
                <div class="card-label">My Profile</div>
                <div class="card-sub">Info & Team</div>
            </a>

            <a href="{{ route('player.fixtures') }}" class="dash-card c-schedule">
                <div class="card-icon-wrap icon-schedule"><i class="bi bi-calendar-event"></i></div>
                <div class="card-label">Schedule</div>
                <div class="card-sub">Match Dates</div>
            </a>

            <a href="#" class="dash-card c-standings">
                <div class="card-icon-wrap icon-standings"><i class="bi bi-bar-chart-line"></i></div>
                <div class="card-label">Standings</div>
                <div class="card-sub">Rankings</div>
            </a>

           <a href="{{ route('player.rules.view') }}" class="dash-card c-rules">
                <div class="card-icon-wrap icon-rules"><i class="bi bi-journal-text"></i></div>
                <div class="card-label">Rules</div>
                <div class="card-sub">Guidelines</div>
            </a>

            <a href="#" class="dash-card c-settings">
                <div class="card-icon-wrap icon-settings"><i class="bi bi-gear-fill"></i></div>
                <div class="card-label">Settings</div>
                <div class="card-sub">Preferences</div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>