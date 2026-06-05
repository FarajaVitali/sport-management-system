@extends('layout.base')

@section('title', 'Admin Dashboard')

@section('content')

<h4 class="mb-3">Users</h4>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">

        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>College</th>
                <th>Sport</th>
                <th>Position</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->college }}</td>
                <td>{{ $user->sport }}</td>
                <td>{{ $user->position }}</td>

                <td>
                    <span class="badge 
                        @if($user->status == 'active') bg-success
                        @elseif($user->status == 'banned') bg-danger
                        @else bg-warning text-dark
                        @endif">
                        {{ $user->status }}
                    </span>
                </td>

                <td>
                    <div class="d-flex gap-2">

                        <form action="/admin/allow/{{ $user->id }}" method="post">
                            @csrf
                            <button class="btn btn-success btn-sm">Allow</button>
                        </form>

                        <form action="/admin/ban/{{ $user->id }}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-sm">Ban</button>
                        </form>

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
