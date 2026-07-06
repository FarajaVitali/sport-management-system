<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage System Rules</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        .fs-7 { font-size: 0.85rem; }
        .tracking-wider { letter-spacing: 0.05em; }
        
        .rule-card { 
            transition: all 0.2s ease-in-out; 
            border-left: 4px solid transparent !important;
        }
        .rule-card:hover { 
            transform: translateY(-3px); 
            border-left-color: #0d6efd !important; 
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08) !important;
            background-color: #ffffff !important;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: #86b7fe;
        }
    </style>
</head>
<body class="p-4">

    <div class="container-fluid px-4 py-3 mx-auto" style="max-width: 1400px;">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary-subtle">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-white border shadow-sm d-flex align-items-center gap-2 px-3 py-2 text-decoration-none text-dark fw-medium rounded-3 hover-bg-light">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
                <div class="ms-2">
                    <h4 class="mb-1 text-dark fw-bold">Competition Rules</h4>
                    <p class="text-muted small mb-0">Establish and manage the guidelines for the tournament.</p>
                </div>
            </div>
            
            <div class="badge bg-primary bg-gradient px-4 py-2 fs-6 rounded-pill shadow-sm">
                <i class="bi bi-shield-check me-1"></i> Total Rules: {{ count($rules) }}
            </div>
        </div>

        <!-- Success Message Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3" role="alert">
                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 32px; height: 32px;">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="fw-medium text-success-emphasis">{{ session('success') }}</div>
                <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <!-- Left Column: Add New Rule Form -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 20px;">
                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                        <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="bi bi-plus-lg fw-bold"></i>
                        </div>
                        <h6 class="text-uppercase tracking-wider text-dark fw-bold mb-0">Add New Rule</h6>
                    </div>
                    
                    <form action="{{ route('admin.rules.store') }}" method="POST">
                        @csrf
                        
                        <!-- Dynamic Sport Dropdown -->
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Select Sport <span class="text-danger">*</span></label>
                            <select name="sport" class="form-select bg-light rounded-3 py-2" required>
                                <option value="" disabled selected>Choose a sport...</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->name }}">{{ $sport->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Rule Category -->
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Rule Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select bg-light rounded-3 py-2" required>
                                <option value="General" selected>General</option>
                                <option value="Matchplay">Matchplay</option>
                                <option value="Discipline">Discipline</option>
                                <option value="Eligibility">Player Eligibility</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Rule Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control bg-light rounded-3 py-2" placeholder="e.g., Yellow Card Penalty" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold">Detailed Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control bg-light rounded-3 py-2" rows="5" placeholder="Clearly explain the parameters of this rule..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-medium rounded-3 shadow-sm d-flex justify-content-center align-items-center gap-2">
                            <i class="bi bi-save"></i> Save to System
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Existing Rules List (Grouped by Sport) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                        <div class="bg-info-subtle text-info rounded d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="bi bi-ui-checks-grid fw-bold"></i>
                        </div>
                        <h6 class="text-uppercase tracking-wider text-dark fw-bold mb-0">Active Guidelines</h6>
                    </div>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills mb-4 gap-2" id="sportTabs" role="tablist">
                        @foreach($sports as $index => $sport)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill {{ $index == 0 ? 'active' : '' }}" 
                                        data-bs-toggle="pill" 
                                        data-bs-target="#sport-{{ $sport->id }}" 
                                        type="button">
                                    {{ $sport->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content">
                        @foreach($sports as $index => $sport)
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="sport-{{ $sport->id }}">
                                
                                @php $sportRules = $rules->where('sport', $sport->name); @endphp

                                @if($sportRules->isEmpty())
                                    <div class="text-center py-5">
                                        <i class="bi bi-clipboard-x fs-1 text-secondary"></i>
                                        <p class="text-muted mt-2">No rules added yet for {{ $sport->name }}.</p>
                                    </div>
                                @else
                                    <div class="d-flex flex-column gap-3">
                                        @foreach($sportRules as $rule)
                                            <div class="rule-card p-3 bg-light rounded-4 border border-secondary-subtle">
                                                <div class="d-flex align-items-start gap-3">
                                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-primary shadow-sm fw-bold border" style="width: 45px; height: 45px; flex-shrink: 0;">
                                                        <i class="bi bi-shield-check"></i>
                                                    </div>
                                                    <div class="w-100">
                                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                                            <h6 class="fw-bold text-dark fs-6 mb-0">{{ $rule->title }}</h6>
                                                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill fs-7">{{ $rule->category }}</span>
                                                        </div>
                                                        <p class="text-secondary mb-0 mt-2" style="font-size: 0.95rem; line-height: 1.5;">
                                                            {{ $rule->description }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>