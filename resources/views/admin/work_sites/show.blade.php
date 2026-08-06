@extends('layouts.admin')
@section('title', $workSite->site_name)
@section('content')
<style>
.site-hero{background:linear-gradient(135deg,#1e3f93,#6046c9);color:#fff;border:1px solid #536cce;border-radius:20px;padding:24px;box-shadow:0 18px 45px rgba(0,0,0,.25)}
.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.cardx{background:linear-gradient(180deg,#17233a,#121b2e);color:#eef4ff;border:1px solid #2a3a58;border-radius:16px;padding:17px;box-shadow:0 14px 32px rgba(0,0,0,.18)}
.cardx h1,.cardx h2,.cardx h3,.cardx h4,.cardx h5,.cardx h6,.cardx strong,.cardx td{color:#eef4ff!important}.cardx small,.cardx .text-muted{color:#9cabc4!important}
.person{display:block;text-decoration:none;color:inherit;transition:.18s ease}.person:hover{border-color:#6389e5;transform:translateY(-2px);color:inherit}
.avatarx{width:45px;height:45px;border-radius:14px;background:#24355b;display:grid;place-items:center;font-weight:800;color:#9fbcff;border:1px solid #355183}
.progress-track{height:10px;background:#0b1425;border:1px solid #293a58;border-radius:99px;overflow:hidden}.progress-fill{height:100%;background:linear-gradient(90deg,#3f6fe0,#745ee4)}
.sectionx{margin-top:24px;color:#eef4ff}.photo{width:54px;height:54px;object-fit:cover;border-radius:10px;border:1px solid #344766;background:#0d1628}
.pending-blur{background:#3b311a;border:1px solid #806222;color:#fff1bd;border-radius:12px;padding:12px}
.team-modal .modal-content{background:#121b2e;color:#eef4ff;border:1px solid #30466e;border-radius:18px}.team-modal .modal-header,.team-modal .modal-footer{border-color:#2a3a58}.team-modal .form-select,.team-modal .form-control{background:#0d1628;color:#eef4ff;border-color:#30466e}.team-modal .form-select:focus,.team-modal .form-control:focus{background:#0d1628;color:#eef4ff;border-color:#6389e5;box-shadow:0 0 0 .2rem rgba(99,137,229,.15)}.team-modal .nav-pills .nav-link{color:#bdcbea}.team-modal .nav-pills .nav-link.active{background:#3f6fe0}.team-action-note{color:#9cabc4;font-size:.9rem}
.toggle-header{cursor:pointer;user-select:none;transition:.2s ease}.toggle-header:hover{opacity:.85}
.toggle-chevron{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#24355b;border:1px solid #355183;color:#9fbcff;font-size:14px;transition:.3s ease;flex-shrink:0}
.toggle-header[aria-expanded="false"] .toggle-chevron{transform:rotate(180deg)}
.toggle-body{transition:.3s ease}
input[type="date"]::-webkit-calendar-picker-indicator{filter:invert(1);opacity:.7;cursor:pointer}
.date-filter-bar{background:linear-gradient(180deg,#17233a,#121b2e);border:1px solid #2a3a58;border-radius:16px;padding:16px 20px;margin-top:16px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.date-filter-bar label{color:#9cabc4;font-size:14px;font-weight:600;margin:0}
.date-filter-bar input[type="date"]{background:#0d1628;color:#eef4ff;border:1px solid #30466e;border-radius:10px;padding:8px 12px;font-size:14px}
.date-filter-bar .btn{border-radius:10px}
.date-filter-bar .filter-info{color:#9cabc4;font-size:13px;margin-left:auto}
@media(max-width:1100px){.grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:600px){.grid{grid-template-columns:1fr}.site-hero{padding:18px}.site-hero{flex-direction:column}.site-hero .d-flex{width:100%}.site-hero .btn{flex:1}.date-filter-bar{flex-direction:column;align-items:stretch}.date-filter-bar .filter-info{margin-left:0}}
</style>
<div class="site-hero d-flex justify-content-between align-items-start gap-3"><div><small>WORK SITE</small><h2 class="mb-1">{{ $workSite->site_name }}</h2><div>{{ $workSite->client_name }} · {{ $workSite->location }}</div></div><div class="d-flex gap-2 flex-wrap"><a class="btn btn-warning btn-sm" href="{{ route('admin.work-sites.inventory',$workSite) }}">Inventory</a><a class="btn btn-light btn-sm" href="{{ route('admin.work-sites.edit',$workSite) }}">Edit Site</a><a class="btn btn-outline-light btn-sm" href="{{ route('admin.work-sites') }}">Back</a></div></div>
@if(session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
<div class="grid mt-3"><div class="cardx"><small>Status</small><h4>{{ ucfirst(str_replace('_',' ',$workSite->status)) }}</h4></div><div class="cardx"><small>Overall Progress</small><h4>{{ $siteProgress }}%</h4><div class="progress-track"><div class="progress-fill" style="width:{{ $siteProgress }}%"></div></div></div><div class="cardx"><small>Total Workers</small><h4>{{ $totalWorkers }}</h4></div><div class="cardx"><small>Pending Approval</small><h4>{{ $pendingAttendanceCount }}</h4></div></div>

<div class="date-filter-bar">
    <label>📅 Filter by date:</label>
    <input type="date" id="globalDateFilter" onchange="filterAllByDate()">
    <button class="btn btn-sm btn-outline-light" onclick="clearDateFilter()">Clear</button>
    <span class="filter-info" id="filterInfo">Showing all records</span>
</div>

<h4 class="sectionx">Assigned Site Team</h4><div class="grid">
@foreach([['Project Manager',$workSite->projectManager,'project_manager_id'],['Project Coordinator',$workSite->projectCoordinator,'project_coordinator_id'],['Site Manager',$workSite->siteManager,'site_manager_id'],['Site Supervisor',$workSite->supervisor,'site_supervisor_id'],['Security',$workSite->security,'site_security_id'],['Project Head',$workSite->projectHead,'project_head_id'],['Project Engineer/Architect',$workSite->projectEngineer,'project_engineer_id'],['Work Coordinator',$workSite->workCoordinator,'work_coordinator_id']] as [$label,$person,$position])
<button type="button" class="cardx person text-start border-0 team-card" data-bs-toggle="modal" data-bs-target="#teamActionModal" data-position="{{ $position }}" data-member-id="{{ $person?->id }}" data-member-name="{{ $person?->name ?? 'Unassigned' }}" data-position-label="{{ $label }}"><div class="d-flex gap-3 align-items-center"><div class="avatarx">{{ $person ? strtoupper(substr($person->name,0,1)) : '?' }}</div><div><small>{{ $label }}</small><h5 class="mb-0">{{ $person->name ?? 'Not assigned' }}</h5><span class="text-muted small">{{ $person->mobile ?? $person->email ?? '' }}</span></div></div></button>
@endforeach
</div>

<div class="modal fade team-modal" id="teamActionModal" tabindex="-1" aria-labelledby="teamActionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><div><h5 class="modal-title" id="teamActionTitle">Manage site team</h5><div class="team-action-note" id="selectedTeamMember"></div></div><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <ul class="nav nav-pills nav-fill mb-4" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#change-team-member" type="button">Change position</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#assign-site-ticket" type="button">Assign ticket</button></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="change-team-member">
                    <form method="POST" action="{{ route('admin.work-sites.team.update', $workSite) }}">
                        @csrf @method('PUT')
                        <div class="mb-3"><label class="form-label">Position</label><select class="form-select" name="position" id="teamPosition" required><option value="project_manager_id">Project Manager</option><option value="project_coordinator_id">Project Coordinator</option><option value="site_manager_id">Site Manager</option><option value="site_supervisor_id">Site Supervisor</option><option value="site_security_id">Security</option><option value="project_head_id">Project Head</option><option value="project_engineer_id">Project Engineer/Architect</option><option value="work_coordinator_id">Work Coordinator</option></select></div>
                        <div class="mb-3"><label class="form-label">Team member</label><select class="form-select" name="user_id" id="teamMember"><option value="">Not assigned</option>@foreach($teamMembers as $member)<option value="{{ $member->id }}">{{ $member->name }} — {{ \App\Models\User::roles()[$member->role] ?? ucfirst(str_replace('_', ' ', $member->role)) }}</option>@endforeach</select></div>
                        <button class="btn btn-primary w-100" type="submit">Save team position</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="assign-site-ticket">
                    <form method="POST" action="{{ route('admin.work-sites.tickets.store', $workSite) }}">
                        @csrf
                        <div class="mb-3"><label class="form-label">Assign to</label><select class="form-select" name="assigned_to" id="ticketAssignee"><option value="">Select team member</option>@foreach($teamMembers as $member)<option value="{{ $member->id }}">{{ $member->name }}</option>@endforeach</select></div>
                        <div class="mb-3"><label class="form-label">Site</label><input class="form-control" value="{{ $workSite->site_name }}" readonly></div>
                        <div class="mb-3"><label class="form-label">Zone</label><select class="form-select" name="site_zone_id"><option value="">Select zone (optional)</option>@foreach($workSite->zones as $zone)<option value="{{ $zone->id }}">{{ $zone->zone_name }}{{ $zone->work_type ? ' — '.$zone->work_type : '' }}</option>@endforeach</select></div>
                        <div class="mb-3"><label class="form-label">What work is required?</label><input class="form-control" name="work" maxlength="255" placeholder="Describe the work" required></div>
                        <div class="mb-3"><label class="form-label">Note</label><textarea class="form-control" name="note" rows="3" maxlength="2000" placeholder="Add any instructions or notes"></textarea></div>
                        <button class="btn btn-primary w-100" type="submit">Assign ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
</div>

<div class="sectionx d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#workCasesBody" aria-expanded="false">
    <h4 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Work Cases / Site Works</h4>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.site-zones.create',['work_site_id'=>$workSite->id]) }}">+ Add Site Work</a>
</div>
<div class="collapse toggle-body mt-3" id="workCasesBody">
    <div class="cardx"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Work</th><th>Type</th><th>Supervisor</th><th>Schedule</th><th>Status</th><th>Progress</th><th></th></tr></thead><tbody>@forelse($workSite->zones as $zone)<tr><td>{{ $zone->zone_name }}</td><td>{{ $zone->work_type }}</td><td>{{ $zone->supervisor->name ?? '-' }}</td><td><small>{{ $zone->start_date?->format('d M Y') ?? '-' }} @if($zone->start_time) · {{ date('h:i A', strtotime($zone->start_time)) }} @endif</small><br><small class="text-muted">to {{ $zone->expected_end_date?->format('d M Y') ?? '-' }} @if($zone->end_time) · {{ date('h:i A', strtotime($zone->end_time)) }} @endif</small></td><td>{{ ucfirst(str_replace('_',' ',$zone->status)) }}</td><td style="min-width:150px"><div class="progress-track"><div class="progress-fill" style="width:{{ $zone->progress }}%"></div></div><small>{{ $zone->progress }}%</small></td><td><a href="{{ route('admin.site-zones.edit',$zone) }}">Edit</a></td></tr>@empty<tr><td colspan="7" class="text-center text-muted">No site works added.</td></tr>@endforelse</tbody></table></div></div>
</div>

<div class="sectionx d-flex align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#securityActivityBody" aria-expanded="false" id="security-activity">
    <h4 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Security & Worker Attendance</h4>
</div>
<div class="collapse toggle-body mt-3" id="securityActivityBody">

    <div class="cardx mb-3">
        <div class="d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#securityPunchBody" aria-expanded="false">
            <h5 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Security Punch History</h5>
        </div>
        <div class="collapse toggle-body mt-2" id="securityPunchBody">
            <div class="table-responsive"><table class="table" id="securityPunchTable"><thead><tr><th>Date</th><th>Punch In</th><th>In Photo</th><th>Punch Out</th><th>Out Photo</th></tr></thead><tbody>@forelse($securityAttendance->take(15) as $row)<tr data-date="{{ $row->date?->format('Y-m-d') }}"><td>{{ $row->date->format('d M Y') }}</td><td>{{ optional($row->punch_in)->format('h:i A') ?? '-' }}</td><td>@if($row->punch_in_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_in_photo) }}">@else-@endif</td><td>{{ optional($row->punch_out)->format('h:i A') ?? '-' }}</td><td>@if($row->punch_out_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_out_photo) }}">@else-@endif</td></tr>@empty<tr><td colspan="5" class="text-muted">No security attendance records.</td></tr>@endforelse<tr id="securityPunchNoResults" style="display:none"><td colspan="5" class="text-muted text-center">No security attendance found for the selected date.</td></tr></tbody></table></div>
        </div>
    </div>

    <div class="cardx mb-3">
        <div class="d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#siteVisitorsBody" aria-expanded="false">
            <h5 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Site Visitors</h5>
            <span class="badge bg-primary">{{ $siteVisitors->count() }} records</span>
        </div>
        <div class="collapse toggle-body mt-2" id="siteVisitorsBody">
            <p class="text-muted small mt-2">Only visitors registered at {{ $workSite->site_name }} are shown here.</p>
            <div class="table-responsive"><table class="table align-middle" id="visitorsTable"><thead><tr><th>Photo</th><th>Name</th><th>Phone</th><th>Security</th><th>Check In</th><th>Check Out</th></tr></thead><tbody>@forelse($siteVisitors->take(100) as $visitor)<tr data-date="{{ $visitor->check_in_at?->format('Y-m-d') }}"><td>@if($visitor->photo)<img class="photo" src="{{ asset('storage/'.$visitor->photo) }}">@else-@endif</td><td>{{ $visitor->name }}</td><td>{{ $visitor->mobile ?: '-' }}</td><td>{{ $visitor->recordedBy?->name ?? '-' }}</td><td>{{ $visitor->check_in_at?->format('d M Y h:i A') }}</td><td>{{ $visitor->check_out_at?->format('d M Y h:i A') ?? 'Inside' }}</td></tr>@empty<tr><td colspan="6" class="text-muted">No visitors registered for this work site.</td></tr>@endforelse<tr id="visitorNoResults" style="display:none"><td colspan="6" class="text-muted text-center">No visitors found for the selected date.</td></tr></tbody></table></div>
        </div>
    </div>

    <div class="cardx mb-3">
        <div class="d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#workersWorkingBody" aria-expanded="false">
            <h5 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Workers Currently Working</h5>
            <span class="badge bg-success">{{ $activeWorkerAttendances->count() }} active</span>
        </div>
        <div class="collapse toggle-body mt-2" id="workersWorkingBody">
            <div class="table-responsive"><table class="table align-middle" id="workersWorkingTable"><thead><tr><th>Worker</th><th>Started</th><th>Current Work</th><th>Elapsed</th><th>Start Photo</th></tr></thead><tbody>@forelse($activeWorkerAttendances as $row)@php($currentSession=$row->workSessions->whereNull('ended_at')->first())<tr data-date="{{ $row->attendance_date?->format('Y-m-d') }}"><td><strong>{{ $row->worker->name }}</strong><div class="small text-muted">{{ $row->worker->trade }}</div></td><td>{{ $row->attendance_date->format('d M Y') }}<br>{{ date('h:i A',strtotime($row->punch_in)) }}</td><td>{{ $currentSession?->work_name ?? $row->work_description }}@if($currentSession?->siteZone)<div class="small text-muted">{{ $currentSession->siteZone->zone_name }}</div>@endif</td><td><strong>{{ intdiv($row->workSessions->sum(fn($s)=>$s->minutes),60) }}h {{ $row->workSessions->sum(fn($s)=>$s->minutes)%60 }}m</strong></td><td>@if($row->punch_in_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_in_photo) }}">@endif</td></tr>@empty<tr><td colspan="5" class="text-muted">No workers are currently clocked in.</td></tr>@endforelse<tr id="workersNoResults" style="display:none"><td colspan="5" class="text-muted text-center">No workers found for the selected date.</td></tr></tbody></table></div>
        </div>
    </div>

    <div class="cardx mb-3">
        <div class="d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#pendingApprovalBody" aria-expanded="false">
            <h5 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Pending Supervisor Approval</h5>
        </div>
        <div class="collapse toggle-body mt-2" id="pendingApprovalBody">
            <div id="pendingApprovalList">@forelse($pendingWorkerAttendances as $row)<div class="pending-blur mb-2" data-date="{{ $row->attendance_date?->format('Y-m-d') }}"><strong>{{ $row->worker->name }}</strong> · {{ $row->attendance_date->format('d M Y') }}<span class="badge bg-warning text-dark ms-2">Pending</span><div class="small text-muted">Punch details and photos become official after Site Supervisor approval.</div></div>@empty<p class="text-muted mb-0">No pending attendance.</p>@endforelse</div>
            <p id="pendingNoResults" class="text-muted text-center" style="display:none">No pending attendance found for the selected date.</p>
        </div>
    </div>

    <div class="cardx">
        <div class="d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#approvedAttendanceBody" aria-expanded="false">
            <h5 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Approved Worker Attendance & Work Time</h5>
        </div>
        <div class="collapse toggle-body mt-2" id="approvedAttendanceBody">
            <div class="table-responsive"><table class="table align-middle" id="approvedAttendanceTable"><thead><tr><th>Worker</th><th>Date</th><th>Start / End</th><th>Total Time</th><th>Work Timeline</th><th>Photos</th><th>Approved By</th></tr></thead><tbody>@forelse($approvedWorkerAttendances->take(50) as $row)<tr data-date="{{ $row->attendance_date?->format('Y-m-d') }}"><td><strong>{{ $row->worker->name }}</strong><div class="small text-muted">{{ $row->worker->trade }}</div></td><td>{{ $row->attendance_date->format('d M Y') }}</td><td>{{ $row->punch_in ? date('h:i A',strtotime($row->punch_in)) : '-' }}<br>{{ $row->punch_out ? date('h:i A',strtotime($row->punch_out)) : 'Working' }}</td><td><strong>{{ intdiv($row->working_minutes ?? 0,60) }}h {{ ($row->working_minutes ?? 0)%60 }}m</strong></td><td style="min-width:260px">@forelse($row->workSessions as $session)<div class="mb-2"><strong>{{ $session->work_name }}</strong><div class="small text-muted">{{ $session->started_at->format('h:i A') }} – {{ $session->ended_at?->format('h:i A') ?? 'Now' }} · {{ $session->minutes }} min @if($session->siteZone) · {{ $session->siteZone->zone_name }} @endif</div></div>@empty<span class="text-muted">{{ $row->work_description ?: 'No timeline' }}</span>@endforelse</td><td><div class="d-flex gap-1">@if($row->punch_in_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_in_photo) }}">@endif @if($row->punch_out_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_out_photo) }}">@endif</div></td><td>{{ $row->approvedBy->name ?? '-' }}</td></tr>@empty<tr><td colspan="7" class="text-muted">No approved attendance.</td></tr>@endforelse<tr id="approvedNoResults" style="display:none"><td colspan="7" class="text-muted text-center">No approved attendance found for the selected date.</td></tr></tbody></table></div>
        </div>
    </div>

</div>

{{-- ─── Daily Work Updates ─── --}}
<div class="sectionx d-flex align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#dailyUpdatesBody" aria-expanded="true" id="daily-updates">
    <h4 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">▼</span> Daily Work Updates</h4>
    <span class="badge ms-2" style="background:var(--bs-indigo,#6f42c1);border-radius:12px;padding:4px 12px;font-size:12px;">{{ $dailyWorkUpdates->count() }}</span>
</div>
<div class="collapse toggle-body mt-3 show" id="dailyUpdatesBody">
    {{-- Updates log --}}
    <div class="cardx">
        @forelse($dailyWorkUpdates as $upd)
            <div class="d-flex gap-3 align-items-start py-3" style="border-bottom:1px solid #2a3a58;" data-date="{{ $upd->date->format('Y-m-d') }}">
                @if($upd->photo)
                    <a href="{{ asset('storage/'.$upd->photo) }}" target="_blank" style="flex-shrink:0;">
                        <img src="{{ asset('storage/'.$upd->photo) }}"
                             style="width:80px;height:80px;object-fit:cover;border-radius:12px;border:1px solid #344766;">
                    </a>
                @else
                    <div style="width:80px;height:80px;border-radius:12px;border:1px dashed #344766;display:grid;place-items:center;color:#9cabc4;font-size:26px;flex-shrink:0;">📷</div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                        <span style="font-weight:700;color:#eef4ff;">{{ $upd->date->format('d M Y') }}</span>
                        <span style="font-size:12px;color:#9cabc4;">{{ $upd->user->name ?? '—' }} · {{ $upd->created_at->diffForHumans() }}</span>
                    </div>
                    @if($upd->note)
                        <p style="margin:0;font-size:13px;color:#bdcbea;line-height:1.6;word-break:break-word;">{{ $upd->note }}</p>
                    @else
                        <p style="margin:0;font-size:12px;color:#9cabc4;font-style:italic;">No note added.</p>
                    @endif

                    <div style="margin-top:10px;display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                        @if($upd->approval_status === 'pending')
                            <span style="background:rgba(242,181,59,.15);border:1px solid rgba(242,181,59,.4);color:#fff1bd;border-radius:8px;padding:3px 10px;font-size:11px;font-weight:600;">⏳ Pending</span>
                            <form method="POST" action="{{ route('admin.daily-updates.approve', $upd) }}" style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-success" type="submit" style="font-size:11px;padding:4px 12px;">✅ Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.daily-updates.reject', $upd) }}" style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-danger" type="submit" style="font-size:11px;padding:4px 12px;">❌ Reject</button>
                            </form>
                        @elseif($upd->approval_status === 'approved')
                            <span style="background:rgba(55,194,129,.15);border:1px solid rgba(55,194,129,.4);color:#c9ffe2;border-radius:8px;padding:3px 10px;font-size:11px;font-weight:600;">✅ Approved</span>
                            <span style="font-size:11px;color:#9cabc4;">by {{ $upd->approvedBy->name ?? '—' }} · {{ $upd->approved_at?->diffForHumans() ?? '' }}</span>
                        @elseif($upd->approval_status === 'rejected')
                            <span style="background:rgba(255,90,110,.15);border:1px solid rgba(255,90,110,.4);color:#ffdce2;border-radius:8px;padding:3px 10px;font-size:11px;font-weight:600;">❌ Rejected</span>
                            <span style="font-size:11px;color:#9cabc4;">by {{ $upd->approvedBy->name ?? '—' }} · {{ $upd->approved_at?->diffForHumans() ?? '' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No daily updates posted yet.</p>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.team-card').forEach(function (card) {
        card.addEventListener('click', function () {
            document.getElementById('teamPosition').value = card.dataset.position;
            document.getElementById('teamMember').value = card.dataset.memberId || '';
            document.getElementById('ticketAssignee').value = card.dataset.memberId || '';
            document.getElementById('selectedTeamMember').textContent = card.dataset.positionLabel + ': ' + card.dataset.memberName;
        });
    });

    document.querySelectorAll('.toggle-header').forEach(function(header) {
        header.addEventListener('click', function(e) {
            if (e.target.closest('a') || e.target.closest('button')) return;
        });
    });

    window.filterAllByDate = function() {
        var input = document.getElementById('globalDateFilter').value;
        var info = document.getElementById('filterInfo');
        var totalVisible = 0;

        var sections = [
            { tableId: 'securityPunchTable', noResultsId: 'securityPunchNoResults' },
            { tableId: 'visitorsTable', noResultsId: 'visitorNoResults' },
            { tableId: 'workersWorkingTable', noResultsId: 'workersNoResults' },
            { tableId: 'approvedAttendanceTable', noResultsId: 'approvedNoResults' }
        ];

        sections.forEach(function(section) {
            var table = document.getElementById(section.tableId);
            if (!table) return;
            var rows = table.querySelectorAll('tbody tr[data-date]');
            var visibleCount = 0;
            rows.forEach(function(row) {
                if (!input || row.dataset.date === input) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            var noResults = document.getElementById(section.noResultsId);
            if (noResults) {
                noResults.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            }
            totalVisible += visibleCount;
        });

        var pendingList = document.getElementById('pendingApprovalList');
        var pendingNoResults = document.getElementById('pendingNoResults');
        if (pendingList) {
            var pendingItems = pendingList.querySelectorAll('[data-date]');
            var pendingVisible = 0;
            pendingItems.forEach(function(item) {
                if (!input || item.dataset.date === input) {
                    item.style.display = '';
                    pendingVisible++;
                } else {
                    item.style.display = 'none';
                }
            });
            if (pendingNoResults) {
                pendingNoResults.style.display = (pendingVisible === 0 && pendingItems.length > 0) ? '' : 'none';
            }
            totalVisible += pendingVisible;
        }

        if (input) {
            info.textContent = 'Showing ' + totalVisible + ' record(s) for ' + input;
        } else {
            info.textContent = 'Showing all records';
        }
    };

    window.clearDateFilter = function() {
        document.getElementById('globalDateFilter').value = '';
        filterAllByDate();
    };
});
</script>
@endsection