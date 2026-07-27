@extends('layouts.app')
@section('content')
<style>
body{background:#0e1320}.navbar{display:none!important}.security-app{max-width:520px;margin:auto;min-height:100vh;padding:18px 16px 90px;color:#edf2ff;background:linear-gradient(180deg,#11182a,#0e1320)}
.row-between{display:flex;justify-content:space-between;align-items:center;gap:12px}.muted{color:#93a0b8;font-size:12px}.panel{background:#171f31;border:1px solid #28334b;border-radius:20px;padding:16px;margin-bottom:14px}.form-control,.form-select{background:#101725!important;border-color:#36415a!important;color:white!important}.form-select option{color:#111}.btn-app{width:100%;border:0;border-radius:13px;padding:12px;font-weight:700;color:white;background:#4169e1}.inventory-cards{display:grid;grid-template-columns:1fr;gap:10px;margin-top:14px}.item{background:#111827;border:1px solid #2a3650;border-radius:16px;padding:12px}.item summary{list-style:none;cursor:pointer}.item summary::-webkit-details-marker{display:none}.item-icon{width:42px;height:42px;border-radius:12px;background:#253454;display:grid;place-items:center;font-size:20px;flex:0 0 42px}.item-head{display:flex;align-items:center;gap:10px}.item-main{min-width:0;flex:1}.item-chevron{font-size:18px;transition:.2s}.item details[open] .item-chevron{transform:rotate(180deg)}.item-body{padding-top:12px;margin-top:12px;border-top:1px solid #28334b}.badge-app{padding:5px 9px;border-radius:999px;font-size:11px}.available{background:#174c39;color:#79e6b9}.inuse{background:#594b21;color:#ffd971}.tabs{position:fixed;bottom:10px;left:50%;transform:translateX(-50%);width:min(488px,calc(100% - 24px));background:#171f31;border:1px solid #28334b;border-radius:20px;padding:11px;display:flex;justify-content:space-around}.tabs a{color:#dbe5f7;text-decoration:none;font-size:12px}@media(max-width:520px){.security-app{padding-left:10px;padding-right:10px}.panel{padding:12px;border-radius:16px}.inventory-cards{grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.item{padding:10px}.item-head{display:block}.item-icon{margin-bottom:8px}.item-main strong{font-size:13px;line-height:1.2;display:block}.item-main .muted{font-size:10px}.badge-app{display:inline-block;margin-top:7px;padding:4px 7px}.item-chevron{position:absolute;right:10px;top:8px}.item details{position:relative}.item-body{font-size:12px}.item-body .form-control,.item-body .form-select,.item-body .btn{font-size:12px}.item-body textarea{min-height:58px}}
</style>
<div class="security-app">
 <div class="row-between mb-3"><div><div class="muted">SITE INVENTORY</div><h3 class="m-0">{{ $site->site_name }}</h3></div><a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('security.dashboard') }}" class="btn btn-sm btn-outline-light">Back</a></div>
 @if(auth()->user()->role === 'admin')
 <div class="panel"><form method="GET" action="{{ route('security.inventory') }}"><label class="muted mb-1">Select Work Site</label><div class="d-flex gap-2"><select name="site_id" class="form-select" onchange="this.form.submit()">@foreach($sites as $workSite)<option value="{{ $workSite->id }}" @selected($workSite->id === $site->id)>{{ $workSite->site_name }}</option>@endforeach</select></div></form></div>
 @endif
 @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
 @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

 <div class="panel" id="add-item">
  <h5>Add Item to Inventory</h5>
  <p class="muted">Choose an existing item or enter a new item name.</p>
  <form method="POST" action="{{ route('security.inventory.store') }}">@csrf
   <input type="hidden" name="site_id" value="{{ $site->id }}">
   <label class="muted mb-1">Existing item (optional)</label>
   <select class="form-select mb-2" name="inventory_item_id">
    <option value="">-- Add as new item --</option>
    @foreach($items as $item)<option value="{{ $item->id }}">{{ $item->item_name }} ({{ $item->item_code }})</option>@endforeach
   </select>
   <input class="form-control mb-2" name="item_name" value="{{ old('item_name') }}" placeholder="New item name">
   <input class="form-control mb-2" name="item_code" value="{{ old('item_code') }}" placeholder="Item code (optional)">
   <div class="row g-2 mb-2"><div class="col-4"><input class="form-control" type="number" min="1" name="quantity" value="{{ old('quantity',1) }}" required></div><div class="col-8"><input class="form-control" name="used_for" value="{{ old('used_for') }}" placeholder="Used for / purpose"></div></div>
   <textarea class="form-control mb-2" name="note" rows="2" placeholder="Condition or note"></textarea>
   <button class="btn-app">+ Add to Site Inventory</button>
  </form>
 </div>

 <div class="panel" id="items">
  <div class="row-between"><h5 class="m-0">Inventory Items</h5><span class="muted">{{ $movements->count() }} records</span></div>
  <div class="inventory-cards">
  @forelse($movements as $movement)
   <div class="item">
    <details>
     <summary>
      <div class="item-head">
       <div class="item-icon">🧰</div>
       <div class="item-main"><strong class="text-truncate">{{ $movement->item->item_name ?? '-' }}</strong><div class="muted text-truncate">{{ $movement->item->item_code ?? '' }} · Qty {{ $movement->quantity }}</div><span class="badge-app {{ ($movement->assignment_status === 'using' || $movement->issued_to) ? 'inuse':'available' }}">{{ ($movement->assignment_status === 'using' || $movement->issued_to) ? 'Using' : ($movement->assignment_status === 'returned' ? 'Returned' : 'Available') }}</span></div>
       <span class="item-chevron">⌄</span>
      </div>
     </summary>
     <div class="item-body">
      <div class="muted">Purpose: {{ $movement->used_for ?: '-' }}</div>
      @if($movement->assignment_status === 'using' || $movement->issued_to)
        <div class="mt-2"><strong>Using:</strong> {{ $movement->issued_to }}</div>
        <form method="POST" action="{{ route('security.inventory.return',$movement) }}" class="mt-2">@csrf<input type="hidden" name="site_id" value="{{ $site->id }}">
         <select class="form-select mb-2" name="return_condition"><option value="good">Good condition</option><option value="damaged">Damaged</option><option value="repair">Needs repair</option></select>
         <textarea class="form-control mb-2" name="return_note" rows="2" placeholder="Return note (optional)"></textarea>
         <button class="btn btn-sm btn-outline-success w-100">Mark Returned</button></form>
      @else
        @if($movement->assignment_status === 'returned')<div class="mt-2"><strong>Returned:</strong> {{ optional($movement->returned_at)->format('d M Y h:i A') ?: '-' }}<br><span class="muted">By {{ $movement->returnedBy->name ?? '-' }} · {{ ucfirst($movement->return_condition ?: 'good') }}</span></div>@endif
        <form method="POST" action="{{ route('security.inventory.assign',$movement) }}" class="mt-3">@csrf<input type="hidden" name="site_id" value="{{ $site->id }}">
         <select class="form-select mb-2" name="worker_id"><option value="">-- Select worker --</option>@foreach($workers as $worker)<option value="{{ $worker->id }}">{{ $worker->name }} ({{ $worker->worker_code }})</option>@endforeach</select>
         <input class="form-control mb-2" name="assigned_to" placeholder="Or enter other person's name">
         <input class="form-control mb-2" name="used_for" value="{{ $movement->used_for }}" placeholder="What are they using it for?">
         <button class="btn btn-sm btn-warning w-100">Assign / Mark User</button>
        </form>
      @endif
     </div>
    </details>
   </div>
  @empty <p class="muted mt-3 mb-0" style="grid-column:1/-1">No items added to this site inventory.</p>@endforelse
  </div>
 </div>
 <div class="tabs"><a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('security.dashboard') }}">Home</a><a href="#add-item">Add Item</a><a href="#items">Inventory</a><a href="{{ route('security.history') }}">History</a></div>
</div>
@endsection
