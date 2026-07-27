@extends('layouts.admin')
@section('title', $workSite->site_name.' Inventory')
@section('content')
<style>
.inv-hero{background:linear-gradient(135deg,#1e3f93,#6046c9);color:#fff;border:1px solid #536cce;border-radius:20px;padding:24px;box-shadow:0 18px 45px rgba(0,0,0,.25)}
.inv-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.inv-card{background:linear-gradient(180deg,#17233a,#121b2e);color:#eef4ff;border:1px solid #2a3a58;border-radius:16px;padding:17px;box-shadow:0 14px 32px rgba(0,0,0,.18)}
.inv-card h1,.inv-card h2,.inv-card h3,.inv-card h4,.inv-card h5,.inv-card strong,.inv-card td{color:#eef4ff!important}.inv-card small,.inv-card .text-muted{color:#9cabc4!important}
.status-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:800;white-space:nowrap}.status-using{background:#5b4519;color:#ffe089}.status-returned{background:#153f63;color:#8ed0ff}.status-available{background:#174c39;color:#79e6b9}.history-box{background:#101827;border:1px solid #2a3a58;border-radius:12px;padding:10px;margin-top:8px;font-size:12px}.history-row{padding:8px 0;border-bottom:1px solid #26344f}.history-row:last-child{border-bottom:0}
.mobile-inventory-grid{display:none}.mobile-item-card{background:#111a2b;border:1px solid #2a3a58;border-radius:15px;padding:13px}.mobile-item-head{display:flex;gap:11px;align-items:center}.mobile-item-icon{width:42px;height:42px;border-radius:12px;display:grid;place-items:center;background:#243558;font-size:20px;flex:0 0 42px}.mobile-item-details{margin-top:12px;padding-top:12px;border-top:1px solid #2a3a58}.detail-line{display:flex;justify-content:space-between;gap:12px;padding:5px 0;font-size:12px}.detail-line span:first-child{color:#9cabc4}.mobile-item-card summary{list-style:none;cursor:pointer}.mobile-item-card summary::-webkit-details-marker{display:none}.mobile-chevron{font-size:18px;transition:.2s}.mobile-item-card details[open] .mobile-chevron{transform:rotate(180deg)}
@media(max-width:700px){.inv-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.inv-card{padding:13px}.inv-hero{padding:16px;flex-direction:column}.inv-hero .d-flex{width:100%}.inv-hero .btn{flex:1}.desktop-inventory-table{display:none}.mobile-inventory-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.inventory-title-row{align-items:flex-start!important}.mobile-item-card{padding:11px}.mobile-item-head{display:block}.mobile-item-icon{margin-bottom:8px}.mobile-item-card strong{font-size:13px;line-height:1.2}.status-pill{padding:4px 7px;font-size:10px}.mobile-item-details{font-size:11px}.detail-line{display:block;padding:4px 0}.detail-line span{display:block}.detail-line span:last-child{margin-top:1px}.history-box{max-height:220px;overflow:auto}}
</style>
<div class="inv-hero d-flex justify-content-between align-items-start gap-3">
    <div><small>WORK SITE INVENTORY</small><h2 class="mb-1">{{ $workSite->site_name }}</h2><div>{{ $workSite->client_name }} · {{ $workSite->location }}</div></div>
    <div class="d-flex gap-2"><a class="btn btn-light btn-sm" href="{{ route('admin.inventory.stock-out',['work_site_id'=>$workSite->id]) }}">+ Issue Item</a><a class="btn btn-outline-light btn-sm" href="{{ route('admin.work-sites.show',$workSite) }}">Back to Site</a></div>
</div>
@if(session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
<div class="inv-grid mt-3"><div class="inv-card"><small>Item Types</small><h3 class="mb-0">{{ $totalItemTypes }}</h3></div><div class="inv-card"><small>Total Quantity</small><h3 class="mb-0">{{ $totalQuantity }}</h3></div></div>
<div class="inv-card mt-3">
 <div class="d-flex justify-content-between align-items-center mb-3 inventory-title-row"><div><h4 class="mb-0">Inventory Items</h4><small class="text-muted">Current user, return status and complete assignment history</small></div></div>
 <div class="table-responsive desktop-inventory-table"><table class="table align-middle"><thead><tr><th>Item</th><th>Qty</th><th>Status</th><th>Using / Last User</th><th>Issue / Return Details</th><th>History</th></tr></thead><tbody>
 @forelse($movements as $movement)
 @php
   $status = $movement->assignment_status ?: ($movement->issued_to ? 'using' : 'available');
   $latestHistory = $movement->assignmentHistories->first();
 @endphp
 <tr>
  <td><strong>{{ $movement->item->item_name ?? '-' }}</strong><br><small>{{ $movement->item->item_code ?? '' }} · {{ $movement->item->category->name ?? '-' }}</small><br><small>Purpose: {{ $movement->used_for ?: '-' }}</small></td>
  <td>{{ $movement->quantity }}</td>
  <td>
   @if($status === 'using')<span class="status-pill status-using">● Using</span>
   @elseif($status === 'returned')<span class="status-pill status-returned">✓ Returned</span>
   @else<span class="status-pill status-available">● Available</span>@endif
  </td>
  <td>
   @if($status === 'using')<strong>{{ $movement->issued_to ?: '-' }}</strong><br><small>Currently using</small>
   @elseif($latestHistory)<span>{{ $latestHistory->assigned_to }}</span><br><small>Last used by</small>
   @else — @endif
  </td>
  <td>
   @if($status === 'using')
    <small>Issued: {{ optional($movement->assigned_at)->format('d M Y h:i A') ?: $movement->created_at->format('d M Y h:i A') }}</small><br><small>Issued by: {{ $latestHistory->assignedBy->name ?? $movement->user->name ?? '-' }}</small>
   @elseif($status === 'returned')
    <small>Returned: {{ optional($movement->returned_at)->format('d M Y h:i A') ?: '-' }}</small><br><small>Returned by: {{ $movement->returnedBy->name ?? '-' }}</small><br><small>Condition: {{ ucfirst($movement->return_condition ?: 'good') }}</small>
    @if($movement->return_note)<br><small>Note: {{ $movement->return_note }}</small>@endif
   @else<small>Added: {{ $movement->created_at->format('d M Y h:i A') }}</small><br><small>Added by: {{ $movement->user->name ?? '-' }}</small>@endif
  </td>
  <td style="min-width:210px">
   @if($movement->assignmentHistories->isNotEmpty())
    <details><summary class="btn btn-sm btn-outline-light">View History ({{ $movement->assignmentHistories->count() }})</summary><div class="history-box">
     @foreach($movement->assignmentHistories as $history)<div class="history-row"><strong>{{ $history->assigned_to }}</strong><br><span>Issued {{ optional($history->assigned_at)->format('d M Y h:i A') }}</span><br><span>By {{ $history->assignedBy->name ?? '-' }}</span>
      @if($history->returned_at)<br><span class="text-info">Returned {{ $history->returned_at->format('d M Y h:i A') }}</span><br><span>By {{ $history->returnedBy->name ?? '-' }} · {{ ucfirst($history->return_condition ?: 'good') }}</span>@else<br><span class="text-warning">Still using</span>@endif
     </div>@endforeach
    </div></details>
   @else <small>No assignment history</small> @endif
  </td>
 </tr>
 @empty<tr><td colspan="6" class="text-center text-muted py-4">No inventory items have been added to this worksite.</td></tr>@endforelse
 </tbody></table></div>
 <div class="mobile-inventory-grid">
 @forelse($movements as $movement)
 @php
   $status = $movement->assignment_status ?: ($movement->issued_to ? 'using' : 'available');
   $latestHistory = $movement->assignmentHistories->first();
 @endphp
 <div class="mobile-item-card">
  <details>
   <summary>
    <div class="mobile-item-head">
     <div class="mobile-item-icon">🧰</div>
     <div style="min-width:0;flex:1">
      <strong class="d-block text-truncate">{{ $movement->item->item_name ?? '-' }}</strong>
      <small class="d-block text-truncate">{{ $movement->item->item_code ?? '' }} · Qty {{ $movement->quantity }}</small>
      <div class="mt-2">@if($status === 'using')<span class="status-pill status-using">● Using</span>@elseif($status === 'returned')<span class="status-pill status-returned">✓ Returned</span>@else<span class="status-pill status-available">● Available</span>@endif</div>
     </div>
     <span class="mobile-chevron">⌄</span>
    </div>
   </summary>
   <div class="mobile-item-details">
    <div class="detail-line"><span>Category</span><span>{{ $movement->item->category->name ?? '-' }}</span></div>
    <div class="detail-line"><span>Purpose</span><span>{{ $movement->used_for ?: '-' }}</span></div>
    <div class="detail-line"><span>{{ $status === 'using' ? 'Using by' : 'Last user' }}</span><span>{{ $status === 'using' ? ($movement->issued_to ?: '-') : ($latestHistory->assigned_to ?? '-') }}</span></div>
    @if($status === 'using')
      <div class="detail-line"><span>Issued</span><span>{{ optional($movement->assigned_at)->format('d M Y h:i A') ?: $movement->created_at->format('d M Y h:i A') }}</span></div>
      <div class="detail-line"><span>Issued by</span><span>{{ $latestHistory->assignedBy->name ?? $movement->user->name ?? '-' }}</span></div>
    @elseif($status === 'returned')
      <div class="detail-line"><span>Returned</span><span>{{ optional($movement->returned_at)->format('d M Y h:i A') ?: '-' }}</span></div>
      <div class="detail-line"><span>Returned by</span><span>{{ $movement->returnedBy->name ?? '-' }}</span></div>
      <div class="detail-line"><span>Condition</span><span>{{ ucfirst($movement->return_condition ?: 'good') }}</span></div>
    @endif
    @if($movement->assignmentHistories->isNotEmpty())
      <details class="mt-2"><summary class="btn btn-sm btn-outline-light w-100">History ({{ $movement->assignmentHistories->count() }})</summary><div class="history-box">
      @foreach($movement->assignmentHistories as $history)<div class="history-row"><strong>{{ $history->assigned_to }}</strong><br><span>Issued {{ optional($history->assigned_at)->format('d M Y h:i A') }}</span>@if($history->returned_at)<br><span class="text-info">Returned {{ $history->returned_at->format('d M Y h:i A') }}</span>@else<br><span class="text-warning">Still using</span>@endif</div>@endforeach
      </div></details>
    @endif
   </div>
  </details>
 </div>
 @empty<div class="text-center text-muted py-4" style="grid-column:1/-1">No inventory items have been added to this worksite.</div>@endforelse
 </div>
<div class="mt-3">{{ $movements->links() }}</div>
</div>
@endsection
