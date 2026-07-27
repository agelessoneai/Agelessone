@extends('layouts.admin')
@section('title','Security Activity')
@section('page-title','Security Activity')
@section('content')
<h4 class="mb-3">Visitor Entries</h4>
<div class="card card-dark p-3 mb-4"><div class="table-responsive"><table class="table table-dark align-middle"><thead><tr><th>Photo</th><th>Name</th><th>Phone</th><th>Site</th><th>Security</th><th>Check In</th><th>Check Out</th></tr></thead><tbody>
@forelse($visitors as $visitor)<tr><td><img src="{{ asset('storage/'.$visitor->photo) }}" width="56" height="56" style="object-fit:cover;border-radius:8px"></td><td>{{ $visitor->name }}</td><td>{{ $visitor->mobile ?: '—' }}</td><td>{{ $visitor->workSite?->site_name }}</td><td>{{ $visitor->recordedBy?->name }}</td><td>{{ $visitor->check_in_at?->format('d M Y h:i A') }}</td><td>{{ $visitor->check_out_at?->format('d M Y h:i A') ?? '-' }}</td></tr>@empty<tr><td colspan="7" class="text-center">No visitor records.</td></tr>@endforelse
</tbody></table></div>{{ $visitors->links() }}</div>

<h4 class="mb-3">Worker Attendance</h4>
<div class="card card-dark p-3"><div class="table-responsive"><table class="table table-dark align-middle"><thead><tr><th>Worker</th><th>Site</th><th>Work</th><th>Supervisor</th><th>Date</th><th>Photos</th><th>Punch Time</th><th>Hours</th><th>Status</th><th>Security</th></tr></thead><tbody>
@forelse($workerAttendances as $row)<tr><td><strong>{{ $row->worker?->name }}</strong><br><small>{{ $row->worker?->trade }}</small></td><td>{{ $row->workSite?->site_name }}</td><td>{{ $row->siteZone?->work_type ?? $row->work_description ?? '—' }}<br><small>{{ $row->work_description }}</small></td><td>{{ $row->supervisor?->name ?? '—' }}</td><td>{{ $row->attendance_date?->format('d M Y') }}</td><td><div class="d-flex gap-1">@if($row->punch_in_photo)<img src="{{ asset('storage/'.$row->punch_in_photo) }}" width="52" height="52" style="object-fit:cover;border-radius:8px">@endif @if($row->punch_out_photo)<img src="{{ asset('storage/'.$row->punch_out_photo) }}" width="52" height="52" style="object-fit:cover;border-radius:8px">@endif</div></td><td>{{ $row->punch_in ?? '-' }}<br>{{ $row->punch_out ?? '-' }}</td><td>{{ intdiv((int)$row->working_minutes,60) }}h {{ ((int)$row->working_minutes)%60 }}m</td><td><span class="badge bg-{{ $row->status==='approved'?'success':($row->status==='rejected'?'danger':'warning') }}">{{ ucfirst($row->status) }}</span></td><td>{{ $row->recordedBy?->name }}</td></tr>@empty<tr><td colspan="10" class="text-center">No worker attendance records.</td></tr>@endforelse
</tbody></table></div>{{ $workerAttendances->links() }}</div>
@endsection
