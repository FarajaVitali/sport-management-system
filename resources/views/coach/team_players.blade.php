@extends('layout.navbar_only')

@section('title', 'My Team Players')

@section('content')
<div class="container py-4 px-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 text-dark fw-bold">Team Roster Management</h4>
            <p class="text-muted small mb-0">Review profiles and physical details of all active players under your selection roster.</p>
        </div>
        <a href="{{ route('coach.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Back Dashboard
        </a>
    </div>

    <div class="card bg-white border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light text-uppercase text-secondary border-bottom">
                    <tr>
                        <th class="ps-4 py-3 fw-bold">Full Name</th>
                        <th class="py-3 fw-bold">Email Address</th>
                        <th class="py-3 fw-bold">Registration / Phone</th>
                        <th class="py-3 fw-bold text-end pe-4">System ID</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($players as $player)
                    <tr class="border-bottom">
                        <td class="ps-4 py-3">
                            <div class="fw-bold text-dark">{{ $player->user->fname }} {{ $player->user->lname }}</div>
                        </td>
                        <td class="text-secondary">{{ $player->user->email }}</td>
                        <td class="text-secondary">
                            <div><i class="bi bi-phone me-1"></i> {{ $player->phone_number ?? 'N/A' }}</div>
                        </td>
                        <td class="text-end pe-4">
                            <span class="badge bg-light text-secondary border font-monospace">PID-{{ $player->id }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted fw-medium">
                            <i class="bi bi-people fs-3 d-block mb-2 text-secondary"></i>
                            No players have registered under your team code workspace yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection