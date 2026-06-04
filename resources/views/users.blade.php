@extends('layouts.dashboard')

@section('contents')

<div class="container-fluid py-4 px-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:#cc0066;">User Management</h4>
            <p class="text-muted small mb-0">Manage system users</p>
        </div>
        <button class="btn btn-pink rounded-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus me-2"></i>Add User
        </button>
    </div>

    <!-- TABLE CARD -->
    <div class="card border-0 shadow-sm" style="border-radius:15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="small fw-semibold" style="color:#555;">#</th>
                            <th class="small fw-semibold" style="color:#555;">Name</th>
                            <th class="small fw-semibold" style="color:#555;">Email</th>
                            <th class="small fw-semibold" style="color:#555;">Role</th>
                            <th class="small fw-semibold" style="color:#555;">Status</th>
                            <th class="small fw-semibold" style="color:#555;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="small text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                         style="width:35px;height:35px;background:linear-gradient(135deg,#ff69b4,#ff1493);font-size:0.85rem;color:white;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($user->fullname, 0, 1)) }}
                                    </div>
                                    <span class="small fw-semibold">{{ $user->fullname }}</span>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2"
                                      style="background:#fff0f7;color:#ff69b4;font-size:0.75rem;">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{ $user->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}"
                                      style="font-size:0.75rem;">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-pink rounded-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal"
                                            data-id="{{ $user->id }}"
                                            data-fullname="{{ $user->fullname }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}"
                                            data-status="{{ $user->status }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <!-- Archive Button -->
                                    <button class="btn btn-sm btn-outline-secondary rounded-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#archiveModal"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->fullname }}">
                                        <i class="fas fa-box-archive"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted small py-4">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" style="color:#cc0066;">
                    <i class="fas fa-user-plus me-2" style="color:#ff69b4;"></i>Add User
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('users.add') }}">
                @csrf
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Full Name</label>
                        <input type="text" name="fullname" class="form-control rounded-3"
                               style="border-color:#ffc0cb;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Email</label>
                        <input type="email" name="email" class="form-control rounded-3"
                               style="border-color:#ffc0cb;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Role</label>
                        <select name="role" class="form-select rounded-3" style="border-color:#ffc0cb;" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <p class="small text-muted mb-0">
                        <i class="fas fa-info-circle me-1" style="color:#ff69b4;"></i>
                        Default password will be set to <strong>password</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-pink rounded-3">
                        <i class="fas fa-plus me-1"></i>Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" style="color:#cc0066;">
                    <i class="fas fa-pen me-2" style="color:#ff69b4;"></i>Edit User
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('users.edit') }}">
                @csrf
                <input type="hidden" name="hiddenId" id="editHiddenId">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Full Name</label>
                        <input type="text" name="fullname" id="editFullname" class="form-control rounded-3"
                               style="border-color:#ffc0cb;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control rounded-3"
                               style="border-color:#ffc0cb;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Role</label>
                        <select name="role" id="editRole" class="form-select rounded-3" style="border-color:#ffc0cb;" required>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#555;">Status</label>
                        <select name="status" id="editStatus" class="form-select rounded-3" style="border-color:#ffc0cb;" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-pink rounded-3">
                        <i class="fas fa-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ARCHIVE CONFIRM MODAL -->
<div class="modal fade" id="archiveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" style="color:#cc0066;">
                    <i class="fas fa-box-archive me-2" style="color:#ff69b4;"></i>Archive User
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('users.archive') }}">
                @csrf
                <input type="hidden" name="hiddenId" id="archiveHiddenId">
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        Are you sure you want to archive <strong id="archiveName"></strong>?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-pink rounded-3">
                        <i class="fas fa-box-archive me-1"></i>Archive
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Populate Edit Modal
    document.getElementById('editUserModal').addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        document.getElementById('editHiddenId').value  = btn.dataset.id;
        document.getElementById('editFullname').value  = btn.dataset.fullname;
        document.getElementById('editEmail').value     = btn.dataset.email;
        document.getElementById('editRole').value      = btn.dataset.role;
        document.getElementById('editStatus').value    = btn.dataset.status;
    });

    // Populate Archive Modal
    document.getElementById('archiveModal').addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        document.getElementById('archiveHiddenId').value = btn.dataset.id;
        document.getElementById('archiveName').textContent = btn.dataset.name;
    });
</script>
@endpush