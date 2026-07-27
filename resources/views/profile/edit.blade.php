@extends($layout)

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<style>
.profile-wrap{max-width:980px;margin:0 auto}.profile-grid{display:grid;grid-template-columns:300px minmax(0,1fr);gap:18px}.profile-card{background:#151b29;border:1px solid #2a3550;border-radius:20px;padding:20px;color:#eef3ff}.profile-photo{width:128px;height:128px;border-radius:28px;object-fit:cover;border:3px solid #405b96;background:#202b43}.profile-placeholder{width:128px;height:128px;border-radius:28px;display:grid;place-items:center;margin:auto;background:linear-gradient(135deg,#4776e6,#8e54e9);font-size:46px;font-weight:900}.profile-label{font-size:12px;color:#93a3bd;margin-bottom:6px}.profile-value{font-weight:700}.form-control{background:#0e1626!important;border-color:#34415e!important;color:#fff!important}.form-control:focus{border-color:#5b83ee!important;box-shadow:0 0 0 .2rem rgba(91,131,238,.18)!important}.btn-brand{background:linear-gradient(135deg,#4776e6,#7453df);border:0;color:#fff;font-weight:800}.role-pill{display:inline-block;border-radius:999px;padding:6px 11px;background:#263657;color:#cbd9ff;font-size:12px;font-weight:800}@media(max-width:760px){.profile-grid{grid-template-columns:1fr}.profile-wrap{padding-bottom:20px}.profile-card{border-radius:18px;padding:16px}}
</style>

<div class="profile-wrap">
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="profile-grid">
        <aside class="profile-card text-center">
            @if($user->photo)
                <img class="profile-photo" src="{{ asset('storage/'.$user->photo) }}" alt="{{ $user->display_name }}">
            @else
                <div class="profile-placeholder">{{ strtoupper(substr($user->display_name, 0, 1)) }}</div>
            @endif
            <h4 class="mt-3 mb-1">{{ $user->display_name }}</h4>
            <div class="text-secondary mb-3">{{ $user->email }}</div>
            <span class="role-pill">{{ \App\Models\User::roles()[$user->role] ?? ucfirst(str_replace('_',' ',$user->role)) }}</span>
            @if($user->department)<div class="mt-3"><div class="profile-label">Department</div><div class="profile-value">{{ $user->department }}</div></div>@endif
            <div class="mt-3"><div class="profile-label">Account Status</div><div class="profile-value text-capitalize">{{ $user->status }}</div></div>
        </aside>

        <div>
            <section class="profile-card mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3"><div><h4 class="mb-1">Personal Information</h4><div class="text-secondary small">Update your contact and profile details.</div></div></div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Full Name *</label><input required class="form-control" name="name" value="{{ old('name',$user->name) }}"></div>
                        <div class="col-md-6"><label class="form-label">Email *</label><input required type="email" class="form-control" name="email" value="{{ old('email',$user->email) }}"></div>
                        <div class="col-md-6"><label class="form-label">Mobile Number</label><input class="form-control" name="mobile" value="{{ old('mobile',$user->mobile) }}"></div>
                        <div class="col-md-6"><label class="form-label">Profile Photo</label><input type="file" class="form-control" name="photo" accept="image/*" capture="user"></div>
                        @if($user->photo)<div class="col-12"><label class="form-check"><input class="form-check-input" type="checkbox" name="remove_photo" value="1"><span class="form-check-label">Remove current profile photo</span></label></div>@endif
                        <div class="col-12"><label class="form-label">Address</label><textarea class="form-control" rows="3" name="address">{{ old('address',$user->address) }}</textarea></div>
                        <div class="col-12"><button class="btn btn-brand px-4" type="submit">Save Profile</button></div>
                    </div>
                </form>
            </section>

            <section class="profile-card">
                <h4 class="mb-1">Change Password</h4>
                <div class="text-secondary small mb-3">Enter your current password before choosing a new one.</div>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Current Password *</label><input required type="password" class="form-control" name="current_password" autocomplete="current-password"></div>
                        <div class="col-md-6"><label class="form-label">New Password *</label><input required type="password" class="form-control" name="password" minlength="8" autocomplete="new-password"></div>
                        <div class="col-md-6"><label class="form-label">Confirm New Password *</label><input required type="password" class="form-control" name="password_confirmation" minlength="8" autocomplete="new-password"></div>
                        <div class="col-12"><button class="btn btn-brand px-4" type="submit">Change Password</button></div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
