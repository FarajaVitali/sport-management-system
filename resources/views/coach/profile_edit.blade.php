@extends('layout.navbar_only')

@section('title', 'Modify Security Settings')

@section('content')
<div class="container py-4 px-4" style="max-width: 650px;">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-dark fw-bold">Modify Credentials</h4>
        <a href="{{ route('coach.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            Cancel
        </a>
    </div>

    <div class="card bg-white border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('coach.profile.update') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">First Name</label>
                    <input type="text" name="fname" class="form-control form-control-custom" value="{{ old('fname', $user->fname) }}" required style="background-color: #f8fafc; border-radius: 8px; padding: 10px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Last Name</label>
                    <input type="text" name="lname" class="form-control form-control-custom" value="{{ old('lname', $user->lname) }}" required style="background-color: #f8fafc; border-radius: 8px; padding: 10px;">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold text-secondary">Email Routing Handle</label>
                    <input type="email" name="email" class="form-control form-control-custom" value="{{ old('email', $user->email) }}" required style="background-color: #f8fafc; border-radius: 8px; padding: 10px;">
                </div>
                
                <hr class="my-4 text-muted opacity-25">
                
                <div class="col-12">
                    <label class="form-label small fw-semibold text-secondary">New Access Password (Leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••" style="background-color: #f8fafc; border-radius: 8px; padding: 10px;">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold text-secondary">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-custom" placeholder="••••••••" style="background-color: #f8fafc; border-radius: 8px; padding: 10px;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4 py-2.5 fw-semibold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                Save Profile Parameters
            </button>
        </form>
    </div>
</div>
@endsection