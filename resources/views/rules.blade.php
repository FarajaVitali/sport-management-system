<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Rules</title>
    <!-- Bootstrap 5 CSS -->
     <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
</head>
<body class="bg-light p-4">

    <div class="container" style="max-width: 900px;">
        <div class="mb-5 text-center">
            <h1 class="fw-bold">Official Tournament Rules</h1>
            <p class="text-muted">Select a sport to view its specific guidelines.</p>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-pills justify-content-center mb-4 gap-2" id="sportTabs" role="tablist">
            @foreach($sports as $index => $sport)
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill {{ $index == 0 ? 'active' : '' }}" 
                            id="tab-{{ $sport->id }}" 
                            data-bs-toggle="pill" 
                            data-bs-target="#panel-{{ $sport->id }}" 
                            type="button" 
                            role="tab">
                        {{ $sport->name }}
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="sportTabsContent">
            @foreach($sports as $index => $sport)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" 
                     id="panel-{{ $sport->id }}" 
                     role="tabpanel">
                    
                    @php 
                        $sportRules = $rules->where('sport', $sport->name); 
                    @endphp

                    @if($sportRules->isEmpty())
                        <div class="card border-0 shadow-sm p-5 text-center">
                            <i class="bi bi-info-circle fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No rules have been set for {{ $sport->name }} yet.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($sportRules as $rule)
                                <div class="card border-0 shadow-sm p-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="text-primary fs-4"><i class="bi bi-shield-check"></i></div>
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $rule->title }}</h5>
                                            <span class="badge bg-secondary mb-2">{{ $rule->category }}</span>
                                            <p class="text-secondary mb-0">{{ $rule->description }}</p>
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

    <!-- Bootstrap 5 JavaScript (Required for Tabs) -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>