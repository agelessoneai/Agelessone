@extends('layouts.admin')
@section('title', 'Expense Management')
@section('page-title', 'Expense Management')
@section('content')
<div class="row g-3 mb-4">
 @foreach(['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $key=>$label)
 <div class="col-md-4"><div class="card card-dark p-3"><div class="muted">{{ $label }} Amount</div><div class="fs-3 fw-bold">{{ number_format($summary[$key], 2) }}</div></div></div>
 @endforeach
</div>
<div class="card card-dark p-3 mb-4">
<form class="row g-2 align-items-end">
 <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option>@foreach(['pending','approved','rejected'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
 <div class="col-md-3"><label class="form-label">Project / Site</label><select name="work_site_id" class="form-select"><option value="">All</option>@foreach($workSites as $site)<option value="{{ $site->id }}" @selected(request('work_site_id')==$site->id)>{{ $site->site_name }}</option>@endforeach</select></div>
 <div class="col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
 <div class="col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
 <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
</form>
</div>
<div class="card card-dark overflow-hidden">
<div class="table-responsive"><table class="table table-dark table-hover align-middle mb-0">
<thead><tr><th>Date / Staff</th><th>Purpose</th><th>Project</th><th>Amount</th><th>Bill</th><th>Status / Review</th></tr></thead>
<tbody>@forelse($expenses as $expense)<tr>
<td>{{ $expense->expense_date->format('d M Y') }}<br><small class="muted">{{ $expense->user?->name }}</small></td>
<td><strong>{{ $expense->purpose }}</strong>@if($expense->description)<br><small class="muted">{{ Str::limit($expense->description, 100) }}</small>@endif</td>
<td>{{ $expense->workSite?->site_name ?? 'Office / General' }}</td>
<td class="fw-bold">{{ number_format($expense->amount, 2) }}</td>
<td>@if($expense->bill_path)<a target="_blank" class="btn btn-sm btn-outline-light" href="{{ Storage::url($expense->bill_path) }}">View Bill</a>@else<span class="muted">No bill</span>@endif</td>
<td style="min-width:240px">
<span class="badge text-bg-{{ $expense->status === 'approved' ? 'success' : ($expense->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($expense->status) }}</span>
@if($expense->status === 'pending')
<form method="POST" action="{{ route('accounts.expenses.review', $expense) }}" class="mt-2">@csrf @method('PUT')
<textarea name="review_note" class="form-control form-control-sm mb-2" rows="2" placeholder="Review note"></textarea>
<div class="d-flex gap-2"><button name="status" value="approved" class="btn btn-sm btn-success">Approve</button><button name="status" value="rejected" class="btn btn-sm btn-danger">Reject</button></div>
</form>
@else
<small class="d-block mt-2 muted">{{ $expense->reviewer?->name }} · {{ optional($expense->reviewed_at)->format('d M Y h:i A') }}</small>
@if($expense->review_note)<small>{{ $expense->review_note }}</small>@endif
@endif
</td></tr>
@empty
<tr><td colspan="6" class="text-center py-5 muted">No expenses found.</td></tr>
@endforelse</tbody>
</table></div><div class="p-3">{{ $expenses->links() }}</div></div>
@endsection
