@extends('layouts.app')
@section('content')
<style>
body{background:#0e1320}.navbar{display:none!important}.security-app{max-width:720px;margin:auto;min-height:100vh;padding:18px 16px 90px;color:#edf2ff;background:linear-gradient(180deg,#11182a,#0e1320)}
.app-head,.row-between{display:flex;justify-content:space-between;align-items:center;gap:12px}.app-head{margin-bottom:16px}.app-head h2{margin:0;font-size:21px}.muted{color:#93a0b8;font-size:12px}.panel{background:#171f31;border:1px solid #28334b;border-radius:22px;padding:17px;margin-bottom:15px}.site-banner{background:linear-gradient(135deg,#4169e1,#8758e8)}.site-banner h3{margin:4px 0}.entry{border-top:1px solid #28334b;padding:14px 0}.entry:first-of-type{border-top:0}.badge-app{padding:5px 9px;border-radius:999px;font-size:11px}.pending{background:#594b21;color:#ffd971}.inside{background:#174c39;color:#79e6b9}.done{background:#1f3f70;color:#a9c8ff}.photo{width:44px;height:44px;object-fit:cover;border-radius:10px}.tabs{position:fixed;bottom:10px;left:50%;transform:translateX(-50%);width:min(688px,calc(100% - 24px));background:#171f31;border:1px solid #28334b;border-radius:20px;padding:11px;display:flex;justify-content:space-around}.tabs a{color:#dbe5f7;text-decoration:none;font-size:12px}.pagination{--bs-pagination-bg:#171f31;--bs-pagination-border-color:#36415a;--bs-pagination-color:#dbe5f7;--bs-pagination-hover-bg:#202a40}
</style>
<div class="security-app">
 <div class="app-head"><div><div class="muted">WORKPLACE HISTORY</div><h2>{{ $site->site_name }}</h2></div><a class="btn btn-sm btn-outline-light" href="{{ route('security.dashboard') }}">Back</a></div>
 <div class="panel site-banner"><div class="muted" style="color:#e8e8ff">HISTORY FOR THIS SITE ONLY</div><h3>{{ $site->site_name }}</h3><div>{{ $site->location ?: 'Location not added' }}</div></div>
 <div class="panel"><h5>Worker History</h5>
 @forelse($workerAttendances as $record)
 <div class="entry"><div class="row-between"><div><strong>{{ $record->worker?->name ?? 'Deleted worker' }}</strong><div class="muted">{{ $record->attendance_date?->format('d M Y') }} · {{ $record->worker?->worker_code }} · {{ $record->siteZone?->zone_name ?? 'General work' }}</div></div><span class="badge-app {{ !$record->punch_out?'inside':'done' }}">{{ !$record->punch_out?'Inside':ucfirst($record->status) }}</span></div><div class="muted mt-2">{{ $record->punch_in ?: '--' }} — {{ $record->punch_out ?: 'Not punched out' }} · {{ $record->work_description ?: 'No description' }}</div></div>
 @empty<p class="muted mb-0">No worker attendance history for this workplace.</p>@endforelse
 <div class="mt-3">{{ $workerAttendances->links() }}</div></div>
 <div class="panel"><h5>Visitor History</h5>
 @forelse($visitors as $visitor)
 <div class="entry"><div class="row-between"><div class="d-flex align-items-center gap-2"><img class="photo" src="{{ asset('storage/'.$visitor->photo) }}"><div><strong>{{ $visitor->name }}</strong><div class="muted">{{ $visitor->mobile }} · {{ $visitor->check_in_at?->format('d M Y, h:i A') }}</div></div></div><span class="badge-app {{ $visitor->check_out_at?'done':'inside' }}">{{ $visitor->check_out_at?'Checked out':'Inside' }}</span></div>@if($visitor->check_out_at)<div class="muted mt-2">Out: {{ $visitor->check_out_at->format('d M Y, h:i A') }}</div>@endif</div>
 @empty<p class="muted mb-0">No visitor history for this workplace.</p>@endforelse
 <div class="mt-3">{{ $visitors->links() }}</div></div>
 <div class="tabs"><a href="{{ route('security.dashboard') }}">Home</a><a href="{{ route('security.dashboard') }}#add-worker">Add Worker</a><a href="{{ route('security.dashboard') }}#workers">Punch</a><a href="{{ route('security.history') }}">History</a></div>
</div>
@endsection
