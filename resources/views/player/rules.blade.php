@extends('layout.navbar_only')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Tournament Rules & Regulations</h2>
    
    <div class="accordion" id="rulesAccordion">
        @foreach($rules as $index => $rule)
        <div class="accordion-item border-0 shadow-sm mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                    {{ $rule->title }}
                </button>
            </h2>
            <div id="collapse{{ $index }}" class="accordion-collapse collapse show">
                <div class="accordion-body text-muted">
                    {{ $rule->description }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection