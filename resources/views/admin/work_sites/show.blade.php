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
@media(max-width:1100px){.grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:600px){.grid{grid-template-columns:1fr}.site-hero{padding:18px}.site-hero{flex-direction:column}.site-hero .d-flex{width:100%}.site-hero .btn{flex:1}}
</style>
<div class="site-hero d-flex justify-content-between align-items-start gap-3"><div><small>WORK SITE</small><h2 class="mb-1">{{ $workSite->site_name }}</h2><div>{{ $workSite->client_name }} · {{ $workSite->location }}</div></div><div class="d-flex gap-2 flex-wrap"><a class="btn btn-warning btn-sm" href="{{ route('admin.work-sites.inventory',$workSite) }}">Inventory</a><a class="btn btn-light btn-sm" href="{{ route('admin.work-sites.edit',$workSite) }}">Edit Site</a><a class="btn btn-outline-light btn-sm" href="{{ route('admin.work-sites') }}">Back</a></div></div>
@if(session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
<div class="grid mt-3"><div class="cardx"><small>Status</small><h4>{{ ucfirst(str_replace('_',' ',$workSite->status)) }}</h4></div><div class="cardx"><small>Overall Progress</small><h4>{{ $siteProgress }}%</h4><div class="progress-track"><div class="progress-fill" style="width:{{ $siteProgress }}%"></div></div></div><div class="cardx"><small>Total Workers</small><h4>{{ $totalWorkers }}</h4></div><div class="cardx"><small>Pending Approval</small><h4>{{ $pendingAttendanceCount }}</h4></div></div>
<h4 class="sectionx">Assigned Site Team</h4><div class="grid">
@foreach([['Project Manager',$workSite->projectManager,''],['Project Coordinator',$workSite->projectCoordinator,''],['Site Manager',$workSite->siteManager,''],['Site Supervisor',$workSite->supervisor,''],['Security',$workSite->security,'security']] as [$label,$person,$type])
@php($position = match($label) { 'Project Manager' => 'project_manager_id', 'Project Coordinator' => 'project_coordinator_id', 'Site Manager' => 'site_manager_id', 'Site Supervisor' => 'site_supervisor_id', default => 'site_security_id' })
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
                        <div class="mb-3"><label class="form-label">Position</label><select class="form-select" name="position" id="teamPosition" required><option value="project_manager_id">Project Manager</option><option value="project_coordinator_id">Project Coordinator</option><option value="site_manager_id">Site Manager</option><option value="site_supervisor_id">Site Supervisor</option><option value="site_security_id">Security</option></select></div>
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
<div class="sectionx d-flex justify-content-between align-items-center"><h4>Work Cases / Site Works</h4><a class="btn btn-primary" href="{{ route('admin.site-zones.create',['work_site_id'=>$workSite->id]) }}">+ Add Site Work</a></div>
<div class="cardx"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Work</th><th>Type</th><th>Supervisor</th><th>Schedule</th><th>Status</th><th>Progress</th><th></th></tr></thead><tbody>@forelse($workSite->zones as $zone)<tr><td>{{ $zone->zone_name }}</td><td>{{ $zone->work_type }}</td><td>{{ $zone->supervisor->name ?? '-' }}</td><td><small>{{ $zone->start_date?->format('d M Y') ?? '-' }} @if($zone->start_time) · {{ date('h:i A', strtotime($zone->start_time)) }} @endif</small><br><small class="text-muted">to {{ $zone->expected_end_date?->format('d M Y') ?? '-' }} @if($zone->end_time) · {{ date('h:i A', strtotime($zone->end_time)) }} @endif</small></td><td>{{ ucfirst(str_replace('_',' ',$zone->status)) }}</td><td style="min-width:150px"><div class="progress-track"><div class="progress-fill" style="width:{{ $zone->progress }}%"></div></div><small>{{ $zone->progress }}%</small></td><td><a href="{{ route('admin.site-zones.edit',$zone) }}">Edit</a></td></tr>@empty<tr><td colspan="7" class="text-center text-muted">No site works added.</td></tr>@endforelse</tbody></table></div></div>
<h4 class="sectionx" id="security-activity">Security & Worker Attendance</h4>
<div class="cardx mb-3"><h5>Security Punch History</h5><div class="table-responsive"><table class="table"><thead><tr><th>Date</th><th>Punch In</th><th>In Photo</th><th>Punch Out</th><th>Out Photo</th></tr></thead><tbody>@forelse($securityAttendance->take(15) as $row)<tr><td>{{ $row->date->format('d M Y') }}</td><td>{{ optional($row->punch_in)->format('h:i A') ?? '-' }}</td><td>@if($row->punch_in_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_in_photo) }}">@else-@endif</td><td>{{ optional($row->punch_out)->format('h:i A') ?? '-' }}</td><td>@if($row->punch_out_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_out_photo) }}">@else-@endif</td></tr>@empty<tr><td colspan="5" class="text-muted">No security attendance records.</td></tr>@endforelse</tbody></table></div></div>
<div class="cardx mb-3"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">Site Visitors</h5><span class="badge bg-primary">{{ $siteVisitors->count() }} records</span></div><p class="text-muted small mt-2">Only visitors registered at {{ $workSite->site_name }} are shown here.</p><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Photo</th><th>Name</th><th>Phone</th><th>Security</th><th>Check In</th><th>Check Out</th></tr></thead><tbody>@forelse($siteVisitors->take(100) as $visitor)<tr><td>@if($visitor->photo)<img class="photo" src="{{ asset('storage/'.$visitor->photo) }}">@else-@endif</td><td>{{ $visitor->name }}</td><td>{{ $visitor->mobile ?: '-' }}</td><td>{{ $visitor->recordedBy?->name ?? '-' }}</td><td>{{ $visitor->check_in_at?->format('d M Y h:i A') }}</td><td>{{ $visitor->check_out_at?->format('d M Y h:i A') ?? 'Inside' }}</td></tr>@empty<tr><td colspan="6" class="text-muted">No visitors registered for this work site.</td></tr>@endforelse</tbody></table></div></div>
<div class="cardx mb-3"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">Workers Currently Working</h5><span class="badge bg-success">{{ $activeWorkerAttendances->count() }} active</span></div><div class="table-responsive mt-2"><table class="table align-middle"><thead><tr><th>Worker</th><th>Started</th><th>Current Work</th><th>Elapsed</th><th>Start Photo</th></tr></thead><tbody>@forelse($activeWorkerAttendances as $row)@php($currentSession=$row->workSessions->whereNull('ended_at')->first())<tr><td><strong>{{ $row->worker->name }}</strong><div class="small text-muted">{{ $row->worker->trade }}</div></td><td>{{ $row->attendance_date->format('d M Y') }}<br>{{ date('h:i A',strtotime($row->punch_in)) }}</td><td>{{ $currentSession?->work_name ?? $row->work_description }}@if($currentSession?->siteZone)<div class="small text-muted">{{ $currentSession->siteZone->zone_name }}</div>@endif</td><td><strong>{{ intdiv($row->workSessions->sum(fn($s)=>$s->minutes),60) }}h {{ $row->workSessions->sum(fn($s)=>$s->minutes)%60 }}m</strong></td><td>@if($row->punch_in_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_in_photo) }}">@endif</td></tr>@empty<tr><td colspan="5" class="text-muted">No workers are currently clocked in.</td></tr>@endforelse</tbody></table></div></div>
<div class="cardx mb-3"><h5>Pending Supervisor Approval</h5>@forelse($pendingWorkerAttendances as $row)<div class="pending-blur mb-2"><strong>{{ $row->worker->name }}</strong> · {{ $row->attendance_date->format('d M Y') }}<span class="badge bg-warning text-dark ms-2">Pending</span><div class="small text-muted">Punch details and photos become official after Site Supervisor approval.</div></div>@empty<p class="text-muted mb-0">No pending attendance.</p>@endforelse</div>
<div class="cardx"><h5>Approved Worker Attendance & Work Time</h5><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Worker</th><th>Date</th><th>Start / End</th><th>Total Time</th><th>Work Timeline</th><th>Photos</th><th>Approved By</th></tr></thead><tbody>@forelse($approvedWorkerAttendances->take(50) as $row)<tr><td><strong>{{ $row->worker->name }}</strong><div class="small text-muted">{{ $row->worker->trade }}</div></td><td>{{ $row->attendance_date->format('d M Y') }}</td><td>{{ $row->punch_in ? date('h:i A',strtotime($row->punch_in)) : '-' }}<br>{{ $row->punch_out ? date('h:i A',strtotime($row->punch_out)) : 'Working' }}</td><td><strong>{{ intdiv($row->working_minutes ?? 0,60) }}h {{ ($row->working_minutes ?? 0)%60 }}m</strong></td><td style="min-width:260px">@forelse($row->workSessions as $session)<div class="mb-2"><strong>{{ $session->work_name }}</strong><div class="small text-muted">{{ $session->started_at->format('h:i A') }} – {{ $session->ended_at?->format('h:i A') ?? 'Now' }} · {{ $session->minutes }} min @if($session->siteZone) · {{ $session->siteZone->zone_name }} @endif</div></div>@empty<span class="text-muted">{{ $row->work_description ?: 'No timeline' }}</span>@endforelse</td><td><div class="d-flex gap-1">@if($row->punch_in_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_in_photo) }}">@endif @if($row->punch_out_photo)<img class="photo" src="{{ asset('storage/'.$row->punch_out_photo) }}">@endif</div></td><td>{{ $row->approvedBy->name ?? '-' }}</td></tr>@empty<tr><td colspan="7" class="text-muted">No approved attendance.</td></tr>@endforelse</tbody></table></div></div>
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
});
</script>
@endsection
