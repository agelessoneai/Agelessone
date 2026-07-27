@extends('layouts.admin')
@section('title','Office Staff')
@section('page-title','Office Staff')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="mb-1">Office Staff</h2><p class="muted mb-0">Total staff: {{ $users->total() }}. Site workers are managed inside each Work Site.</p></div>
    <a class="btn btn-primary" href="{{ route('admin.users.create') }}">+ Add Staff</a>
</div>
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-5"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search staff"></div>
    <div class="col-md-3"><select class="form-select" name="role"><option value="">All roles</option>@foreach($roles as $value=>$label)<option value="{{ $value }}" @selected(request('role')===$value)>{{ $label }}</option>@endforeach</select></div>
    <div class="col-md-2"><select class="form-select" name="status"><option value="">All status</option><option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option></select></div>
    <div class="col-md-2"><button class="btn btn-outline-light w-100">Filter</button></div>
</form>
<div class="card card-dark"><div class="table-responsive"><table class="table table-dark table-hover mb-0"><thead><tr><th>Staff</th><th>Contact</th><th>Role</th><th>Department</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($users as $user)<tr><td><strong>{{ $user->name }}</strong><br><small class="muted">#{{ $user->id }}</small></td><td>{{ $user->email }}<br><small>{{ $user->mobile }}</small></td><td>{{ $roles[$user->role] ?? ucfirst(str_replace('_',' ',$user->role)) }}</td><td>{{ $user->department ?: '—' }}</td><td><span class="badge {{ $user->status==='active'?'text-bg-success':'text-bg-secondary' }}">{{ ucfirst($user->status) }}</span></td><td class="text-end"><a class="btn btn-sm btn-outline-light" href="{{ route('admin.users.edit',$user) }}">Edit</a>@if(auth()->id()!==$user->id)<form class="d-inline" method="POST" action="{{ route('admin.users.destroy',$user) }}" onsubmit="return confirm('Delete this staff account?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>@endif</td></tr>
@empty<tr><td colspan="6" class="text-center py-5">No office staff found.</td></tr>@endforelse
</tbody></table></div></div><div class="mt-3">{{ $users->links() }}</div>
@endsection
