@extends('layouts.dashboard')
@section('contents')

@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

<div class="container mt-4">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Customer Records</h3>
            <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addModal">
                + Add New Record
            </button>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <span class="badge {{ $user->status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                data-id="{{ $user->id }}"
                                data-fullname="{{ $user->fullname }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}"
                                data-status="{{ $user->status }}">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->fullname }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add New Record</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.customers.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-control" name="role" required>
                            <option>Admin</option>
                            <option selected>User</option>
                            <option>Staff</option>
                            <option>Customer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <button class="btn btn-pink w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Record</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullname" id="edit_fullname" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-control" name="role" id="edit_role">
                            <option>Admin</option>
                            <option>User</option>
                            <option>Staff</option>
                            <option>Customer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-control" name="status" id="edit_status">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <button class="btn btn-pink w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5>Confirm Delete</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete <strong id="delete_name"></strong>?</p>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    ['successToast', 'errorToast'].forEach(id => {
        const el = document.getElementById(id);
        if (el) new bootstrap.Toast(el).show();
    });

    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        const id = btn.dataset.id;

        document.getElementById('edit_fullname').value = btn.dataset.fullname;
        document.getElementById('edit_email').value    = btn.dataset.email;

        const roleSelect   = document.getElementById('edit_role');
        const statusSelect = document.getElementById('edit_status');

        [...roleSelect.options].forEach(o => o.selected = o.value === btn.dataset.role);
        [...statusSelect.options].forEach(o => o.selected = o.value === btn.dataset.status);

        document.getElementById('editForm').action = `/admin/customers/${id}`;
    });

    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        document.getElementById('delete_name').textContent = btn.dataset.name;
        document.getElementById('deleteForm').action = `/admin/customers/${btn.dataset.id}`;
    });

});
</script>

@endsection
