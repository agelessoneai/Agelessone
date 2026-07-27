@extends('layouts.admin')
@section('title','Workshops')
@section('page-title','Workshop Management')
@push('styles')
<style>
.ws-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px}.ws-card{background:#151b29;border:1px solid #262f47;border-radius:16px;padding:18px;color:#e8edf6}.ws-card a{text-decoration:none;color:inherit}.stat{font-size:26px;font-weight:800}.ws-btn{border:0;border-radius:10px;padding:10px 14px;background:#3f6fe0;color:#fff;font-weight:700}.form-control,.form-select{background:#0f1625;border-color:#33405f;color:#fff}.form-control:focus,.form-select:focus{background:#0f1625;color:#fff}.modal-content{background:#151b29;color:#fff;border:1px solid #33405f}
</style>
@endpush
@section('content')
@if($errors->any())
<div class="alert alert-danger"><strong>Workshop could not be added.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap"><div><h2 class="mb-1">Workshops</h2><div class="muted">In-charge, inventory, workers and project progress</div></div><button class="ws-btn" data-bs-toggle="modal" data-bs-target="#addWorkshop">+ Add Workshop</button></div>
<div class="ws-grid">
@forelse($workshops as $workshop)
<div class="ws-card"><a href="{{ route('workshops.show',$workshop) }}"><div class="d-flex justify-content-between"><h4>{{ $workshop->name }}</h4><span class="badge bg-{{ $workshop->status==='active'?'success':'secondary' }}">{{ ucfirst($workshop->status) }}</span></div><p class="muted mb-3">📍 {{ $workshop->location ?: 'Location not set' }}</p><p class="mb-3">In-charge: <strong>{{ $workshop->inCharge?->name ?: 'Not assigned' }}</strong></p><div class="row text-center"><div class="col"><div class="stat">{{ $workshop->inventory_items_count }}</div><small class="muted">Inventory Items</small></div><div class="col"><div class="stat">{{ $workshop->projects_count }}</div><small class="muted">Projects</small></div></div></a></div>
@empty
<div class="ws-card"><h4>No workshop added</h4><p class="muted mb-0">Create the first workshop to manage inventory and projects.</p></div>
@endforelse
</div>
<div class="modal fade" id="addWorkshop"><div class="modal-dialog"><form method="POST" action="{{ route('workshops.store') }}" class="modal-content">@csrf<div class="modal-header"><h5>Add Workshop</h5><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label>Name</label><input required name="name" value="{{ old('name') }}" class="form-control"></div><div class="mb-3"><label>Location</label><input name="location" value="{{ old('location') }}" class="form-control"></div><div class="mb-3"><label>In-charge</label><select name="in_charge_user_id" class="form-select"><option value="">Select</option>@foreach($managers as $manager)<option value="{{ $manager->id }}" @selected(old('in_charge_user_id') == $manager->id)>{{ $manager->name }}</option>@endforeach</select></div><div class="mb-3"><label>Description</label><textarea name="description" class="form-control">{{ old('description') }}</textarea></div><input type="hidden" name="status" value="active"></div><div class="modal-footer"><button class="ws-btn">Save Workshop</button></div></form></div></div>
@endsection

@push('scripts')
@if($errors->any())
<script>document.addEventListener('DOMContentLoaded',()=>{const el=document.getElementById('addWorkshop');if(el){bootstrap.Modal.getOrCreateInstance(el).show();}});</script>
@endif
@endpush
