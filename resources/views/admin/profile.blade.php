@extends('layouts.dashboard')

@section('contents')

@php $user = session('user'); @endphp

<div class="container-fluid py-4 px-4">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:#cc0066;">My Profile</h4>
            <p class="text-muted small mb-0">Manage your account information</p>
        </div>
        <div class="d-flex align-items-center gap-2 text-muted small border rounded-3 px-3 py-2 bg-white">
            <i class="fas fa-calendar-alt" style="color:#ff69b4;"></i>
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius:15px;">
                <div class="mx-auto mb-3 position-relative" style="width:100px;height:100px;">
                    @if($user && $user->profile_picture)
                        <img src="/uploads/{{$user->profile_picture}}"
                             alt="Profile"
                             class="rounded-circle object-fit-cover border"
                             style="width:100px;height:100px;object-fit:cover;border-color:#ffc0cb !important;border-width:3px !important;">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:100px;height:100px;background:linear-gradient(135deg,#ff69b4,#ff1493);font-size:2.2rem;color:white;font-weight:700;">
                            {{ strtoupper(substr($user->fullname ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h5 class="fw-bold mb-1" style="color:#333;">{{ $user->fullname ?? 'N/A' }}</h5>
                <p class="text-muted small mb-3">{{ $user->email ?? '' }}</p>

                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge rounded-pill px-3 py-2"
                          style="background:#fff0f7;color:#ff69b4;font-size:0.78rem;font-weight:600;">
                        <i class="fas fa-shield-alt me-1"></i>{{ ucfirst($user->role ?? 'user') }}
                    </span>
                    <span class="badge rounded-pill px-3 py-2
                          {{ ($user->status ?? '') === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}"
                          style="font-size:0.78rem;">
                        <i class="fas fa-circle me-1" style="font-size:0.45rem;vertical-align:middle;"></i>
                        {{ ucfirst($user->status ?? 'inactive') }}
                    </span>
                </div>

                <hr class="my-3">

                <div class="text-start d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <i class="fas fa-envelope" style="color:#ff69b4;width:16px;"></i>
                        {{ $user->email ?? 'N/A' }}
                    </div>
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <i class="fas fa-user-tag" style="color:#ff69b4;width:16px;"></i>
                        Role: {{ ucfirst($user->role ?? 'N/A') }}
                    </div>
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <i class="fas fa-clock" style="color:#ff69b4;width:16px;"></i>
                        Joined {{ isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : 'N/A' }}
                    </div>
                </div>

                <hr class="my-3">

                <form method="POST" action="/admin/editPicture" enctype="multipart/form-data">
                    @csrf
                    <p class="fw-semibold small mb-2 text-start" style="color:#555;">
                        <i class="fas fa-camera me-1" style="color:#ff69b4;"></i> Change Photo
                    </p>
                    <input type="file" name="profile_pic" id="profile_pic"
                           class="form-control form-control-sm rounded-3 mb-3 @error('profile_pic') is-invalid @enderror"
                           accept="image/*"
                           style="border-color:#ffc0cb;"
                           onchange="previewImage(event)">
                    @error('profile_pic')
                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                    @enderror

                    @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 small py-2 mb-3"
                         style="background:#e8f5e9;color:#2e7d32;">
                        <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                    </div>
                    @endif

                    <button type="submit" class="btn btn-pink w-100 rounded-3">
                        <i class="fas fa-upload me-2"></i>Upload Photo
                    </button>
                </form>

            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-4">

                    <h6 class="fw-bold mb-1" style="color:#333;">
                        <i class="fas fa-id-card me-2" style="color:#ff69b4;"></i>Account Details
                    </h6>
                    <p class="text-muted small mb-4">View and update your account information.</p>

                    @if(session('edit_success'))
                        <div class="alert alert-success border-0 rounded-3 small py-2 mb-3"
                            style="background:#e8f5e9;color:#2e7d32;">
                            <i class="fas fa-check-circle me-1"></i>{{ session('edit_success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small py-2 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/admin/updateProfile">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Full Name</label>
                                <input type="text"
                                    name="fullname"
                                    class="form-control rounded-3 @error('fullname') is-invalid @enderror"
                                    value="{{ old('fullname', $user->fullname ?? '') }}"
                                    style="border-color:#ffc0cb;">
                                @error('fullname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Email Address</label>
                                <input type="email"
                                    name="email"
                                    class="form-control rounded-3 @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email ?? '') }}"
                                    style="border-color:#ffc0cb;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Role</label>
                                <input type="text" class="form-control rounded-3"
                                    value="{{ ucfirst($user->role ?? 'N/A') }}" disabled
                                    style="background:#f9f9f9;border-color:#eee;">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Status</label>
                                <input type="text" class="form-control rounded-3"
                                    value="{{ ucfirst($user->status ?? 'N/A') }}" disabled
                                    style="background:#f9f9f9;border-color:#eee;">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Email Verified</label>
                                <input type="text" class="form-control rounded-3"
                                    value="{{ $user->email_verified_at ? 'Verified on ' . \Carbon\Carbon::parse($user->email_verified_at)->format('M d, Y') : 'Not Verified' }}"
                                    disabled style="background:#f9f9f9;border-color:#eee;">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Member Since</label>
                                <input type="text" class="form-control rounded-3"
                                    value="{{ isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : 'N/A' }}"
                                    disabled style="background:#f9f9f9;border-color:#eee;">
                            </div>

                            <div class="col-12">
                                <hr class="my-1">
                                <p class="fw-semibold small mb-2 mt-2" style="color:#555;">
                                    <i class="fas fa-lock me-1" style="color:#ff69b4;"></i>Change Password
                                    <span class="text-muted fw-normal">(leave blank to keep current)</span>
                                </p>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">New Password</label>
                                <input type="password"
                                    name="password"
                                    class="form-control rounded-3 @error('password') is-invalid @enderror"
                                    placeholder="New password"
                                    style="border-color:#ffc0cb;">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small" style="color:#555;">Confirm Password</label>
                                <input type="password"
                                    name="password_confirmation"
                                    class="form-control rounded-3"
                                    placeholder="Confirm new password"
                                    style="border-color:#ffc0cb;">
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-pink px-4 rounded-3">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file   = event.target.files[0];
    const avatar = document.querySelector('.rounded-circle img, .rounded-circle div');
    if (!file || !avatar) return;

    const reader = new FileReader();
    reader.onload = e => {
        const container = document.querySelector('.position-relative');
        container.innerHTML = `<img src="${e.target.result}"
            class="rounded-circle object-fit-cover border"
            style="width:100px;height:100px;object-fit:cover;border-color:#ffc0cb !important;border-width:3px !important;">`;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush