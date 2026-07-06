<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Management System - Your Ultimate Sports Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Modern Reset & Variable Setup */
        :root {
            --primary: #2563eb;       /* Modern Premium Blue */
            --primary-dark: #1d4ed8;
            --accent: #f97316;        /* Energetic Sports Orange */
            --dark: #0f172a;          /* Sleek Slate Gray */
            --light: #f8fafc;
            --border: #e2e8f0;
            --text-muted: #64748b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: var(--dark);
            line-height: 1.5;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Navbar Improvement */
        header {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 16px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo i { color: var(--primary); }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 15px;
            margin-left: 24px;
            transition: color 0.2s;
        }
        .nav-links a:hover, .nav-links a.active {
            color: var(--primary);
        }

        .nav-btn {
            background-color: var(--primary);
            color: white !important;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
        }
        .nav-btn:hover {
            background-color: var(--primary-dark);
        }

        /* Modernized Hero Section Layout */
        #hero {
            padding: 80px 0;
            background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%);
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 48px;
        }

        #hero h2 {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.15;
            color: var(--dark);
            margin-bottom: 20px;
        }

        #hero p {
            font-size: 18px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
        }

        /* Reusable Modern Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #ffffff;
            color: var(--dark);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover {
            background-color: var(--light);
        }

        /* Mockup Graphic placeholder */
        .hero-graphic {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--border);
        }

        /* Key Features Grid Layout */
        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 16px;
            margin-bottom: 48px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features {
            padding: 80px 0;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
        }

        .feature-item {
            background: var(--light);
            padding: 32px;
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        .feature-item:hover {
            transform: translateY(-4px);
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.04);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: #dbeafe;
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .feature-item h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .feature-item p {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Glassmorphic User Roles Layout */
        .user-roles {
            padding: 80px 0;
            background-color: var(--light);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .role-item {
            background: #ffffff;
            border-radius: 12px;
            padding: 32px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px rgba(0,0,0,0.01);
        }

        .role-item h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .role-item:nth-child(1) h4 { color: #10b981; }
        .role-item:nth-child(2) h4 { color: #f59e0b; }
        .role-item:nth-child(3) h4 { color: #3b82f6; }

        .role-item ul {
            list-style: none;
        }

        .role-item ul li {
            margin-bottom: 12px;
            font-size: 14px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-item ul li i {
            color: #10b981;
            font-size: 12px;
        }

        /* Bottom CTA & Footer Formatting */
        #registration-login {
            padding: 100px 0;
            text-align: center;
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            color: #ffffff;
        }

        #registration-login h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        #registration-login p {
            color: #94a3b8;
            margin-bottom: 32px;
        }

        footer {
            background: var(--dark);
            color: #94a3b8;
            text-align: center;
            padding: 24px 0;
            font-size: 14px;
            border-top: 1px solid #1e293b;
        }

        /* Mobile Optimization Rules */
        @media (max-width: 768px) {
            .hero-grid, .role-grid {
                grid-template-columns: 1fr;
            }
            #hero { padding: 40px 0; text-align: center; }
            .hero-actions { justify-content: center; }
            .nav-links { display: none; } 
        }
    </style>
</head>
<body>

    <header>
        <div class="container nav-container">
            <a href="#" class="logo"><i class="fa-solid fa-trophy"></i> SportManage</a>
            <nav class="nav-links">
                <a href="#" class="active">Home</a>
                <a href="#features-section">Features</a>
                <a href="#roles-section">Roles</a>
                <a href="{{route('rules.index')}}">Rules</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register.form') }}" class="nav-btn">Register</a>
            </nav>
        </div>
    </header>

    <section id="hero">
        <div class="container hero-grid">
            <div>
                <h2>Take Absolute Control of Your Sports Data</h2>
                <p>Streamline your sports organization smoothly—from automatic player registrations directly to real-time league matches and dashboard configurations.</p>
                <div class="hero-actions">
                    <a href="{{ route('register.form') }}" class="btn btn-primary">Get Started <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="hero-graphic">
                <div style="display:flex; gap:6px; margin-bottom:16px;">
                    <span style="width:10px; height:10px; background:#ef4444; border-radius:50%"></span>
                    <span style="width:10px; height:10px; background:#f59e0b; border-radius:50%"></span>
                    <span style="width:10px; height:10px; background:#10b981; border-radius:50%"></span>
                </div>
                <div style="height:12px; background:#e2e8f0; border-radius:4px; margin-bottom:10px; width:40%;"></div>
                <div style="height:8px; background:#e2e8f0; border-radius:4px; margin-bottom:24px; width:85%;"></div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div style="height:60px; background:#f1f5f9; border-radius:8px; padding:10px; box-sizing:border-box;"><i class="fa-solid fa-chart-simple" style="color:var(--primary)"></i></div>
                    <div style="height:60px; background:#f1f5f9; border-radius:8px; padding:10px; box-sizing:border-box;"><i class="fa-solid fa-users" style="color:#10b981"></i></div>
                </div>
            </div>
        </div>
    </section>

    <section class="features container" id="features-section">
        <h2 class="section-title">Key Platform Features</h2>
        <p class="section-subtitle">Everything you need to run your tournament system perfectly on any mobile device or workstation monitor.</p>
        
        <div class="feature-grid">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-user-gear"></i></div>
                <h3>Player Management</h3>
                <p>Players can register, customize robust profile cards, view verified historical records, and check scheduling data.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-calendar-days"></i></div>
                <h3>Match & Schedule Tracking</h3>
                <p>Monitor ongoing matches, archive previous seasons, track statistics adjustments, and broadcast live field coordinates.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-book-open"></i></div>
                <h3>Rules & Documentation</h3>
                <p>Publish localized codebooks, assign user code restrictions, and provide clear legal handbooks instantly.</p>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2026 Sport Management System. Engineered for peak athletic workflow.</p>
        </div>
    </footer>
</body>
</html>