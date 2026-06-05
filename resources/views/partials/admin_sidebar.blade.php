<div class="bg-dark text-white p-3" style="min-width: 240px; min-height: 100vh;">
    <h5 class="text-uppercase tracking-wider opacity-75 small mb-4">Management</h5>
    <ul class="nav flex-column gap-2">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white opacity-75 hover-opacity-100">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.players') }}" class="nav-link text-white active fw-bold">
                <i class="bi bi-person-lines-fill me-2"></i> Players List
            </a>
        </li>
    </ul>
</div>