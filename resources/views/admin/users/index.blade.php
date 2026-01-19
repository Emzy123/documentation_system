@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-dark">User Management</h2>
                <p class="text-muted">Manage system users and roles</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="bi bi-person-plus me-2"></i> Add User
            </button>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <select name="role_id" class="form-select" required>
                                <option value="">Select Role...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <x-card>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase small fw-bold text-muted">User</th>
                                <th class="text-uppercase small fw-bold text-muted">Role</th>
                                <th class="text-uppercase small fw-bold text-muted">Email</th>
                                <th class="text-uppercase small fw-bold text-muted">Joined</th>
                                <th class="text-end text-uppercase small fw-bold text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold text-dark">{{ $user->name }}</span>
                                            @if($user->student)
                                            <span class="d-block text-muted small">{{ $user->student->student_number }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $roleColor = match($user->role->slug) {
                                            'admin' => 'danger',
                                            'staff' => 'warning',
                                            default => 'info'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} px-3 py-2 rounded-pill text-uppercase" style="font-size: 0.7rem;">
                                        {{ $user->role->name }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><h6 class="dropdown-header">Danger Zone</h6></li>
                                            <li>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
