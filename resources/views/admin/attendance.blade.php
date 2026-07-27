@extends('layouts.admin')
@section('content')

@php
$authUser = Auth::user();
$initials = strtoupper(substr($authUser->name,0,1));
$roleName = $authUser->role == 'admin' ? 'Administrator' : 'User';
@endphp

<style>
:root{--bg:#0e1320;--bg2:#0b101b;--panel:#151b29;--panel2:#1c2436;--line:#262f47;--txt:#e8edf6;--mut:#8794ac;--brand:#5b8cff;--brand2:#3f6fe0;--brand3:#9b6bff;--ok:#37c281;--crit:#ff5a6e;--warn:#f2b53b}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--txt);font-size:14px;overflow:hidden;font-family:'Segoe UI',system-ui,-apple-system,sans-serif}
.navbar,header{display:none!important}.container{max-width:100%!important;margin:0!important;padding:0!important}
.app{display:grid;grid-template-columns:262px 1fr;height:100vh}
.side{background:linear-gradient(180deg,var(--panel),var(--bg2));border-right:1px solid var(--line)}
.brand{padding:18px;display:flex;gap:11px;align-items:center;border-bottom:1px solid var(--line)}
.logo{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--brand),var(--brand3));display:grid;place-items:center;font-weight:800;font-size:18px}
.brand h1{font-size:15.5px;margin:0}.brand p{font-size:10px;color:var(--mut);margin:0}
.nav-title{padding:18px 23px 8px;color:var(--mut);font-size:9.5px;font-weight:700;letter-spacing:1.2px}
.nav a{display:flex;gap:11px;align-items:center;color:var(--mut);padding:8.5px 12px;margin:1px 10px;border-radius:8px;text-decoration:none;font-size:13.3px}
.nav a.active{background:linear-gradient(90deg,var(--brand2),#3360c8);color:#fff;font-weight:600}
.main{display:flex;flex-direction:column;overflow:hidden}
.top{height:62px;background:var(--panel);border-bottom:1px solid var(--line);display:flex;align-items:center;padding:0 24px;gap:16px}
.search{width:440px;background:var(--bg);border:1px solid var(--line);border-radius:9px;color:var(--txt);padding:10px 14px;font-size:13px}
.user{margin-left:auto;display:flex;align-items:center;gap:10px}.avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#5b8cff,#37c281);display:grid;place-items:center;font-weight:700}
.logout{color:#cbd5e1;border:1px solid var(--line);padding:8px 14px;border-radius:8px;background:transparent;font-size:13px}
.content{flex:1;overflow-y:auto;padding:24px 26px}
h2{font-size:21px;font-weight:700;margin:0}.muted{color:var(--mut)}
.panel{background:var(--panel);border:1px solid var(--line);border-radius:13px;padding:0;overflow:hidden;margin-top:20px}
.table{width:100%;color:var(--txt);margin-bottom:0;border-collapse:collapse;font-size:13px}
.table thead th{background:var(--bg2);color:var(--mut);border-bottom:1px solid var(--line);font-size:10.5px;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px}
.table tbody td{background:var(--panel);color:var(--txt);border-bottom:1px solid var(--line);padding:11px 12px;vertical-align:middle}
.table tbody tr:hover td{background:var(--panel2)}
.badge-in{background:rgba(55,194,129,.18);color:var(--ok);padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700}
.badge-out{background:rgba(255,90,110,.18);color:var(--crit);padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700}
.badge-done{background:rgba(91,140,255,.18);color:#8fb0ff;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700}
.btn-blue{background:linear-gradient(135deg,var(--brand2),#3360c8);color:#fff;padding:9px 16px;border-radius:8px;text-decoration:none;font-weight:600;font-size:13px}
.btn-ok,.btn-reject{border:0;color:#fff;padding:7px 11px;border-radius:7px;font-size:12px;font-weight:700;cursor:pointer}.btn-ok{background:#279b68}.btn-reject{background:#d7475a}.reject-input{min-width:180px;background:var(--bg);border:1px solid var(--line);color:var(--txt);padding:7px 9px;border-radius:7px}.alert-app{margin-top:15px;padding:12px 14px;border-radius:9px}.alert-success-app{background:rgba(55,194,129,.15);color:#75dda9;border:1px solid rgba(55,194,129,.35)}.alert-error-app{background:rgba(255,90,110,.15);color:#ff9aa7;border:1px solid rgba(255,90,110,.35)}.worker-photo{width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid var(--line)}.actions{display:flex;gap:7px;align-items:center;flex-wrap:wrap}
</style>

<div style="display:flex;justify-content:space-between;align-items:center">
                <div>
                    <h2>Staff Attendance</h2>
                    <p class="muted">Punch In / Punch Out records</p>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="btn-blue">Back Dashboard</a>
            </div>

            @if(session('success'))
                <div class="alert-app alert-success-app">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-app alert-error-app">{{ $errors->first() }}</div>
            @endif

            <div class="panel">
                <div style="padding:16px 18px;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center">
                    <div><h3 style="margin:0;font-size:17px">Attendance Photo Alerts</h3><p class="muted" style="margin:5px 0 0">Mismatch or unverified photos are saved and reported here for Admin review.</p></div>
                    <span class="badge-out">{{ $photoAlerts->whereNull('read_at')->count() }} Unread</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Status</th><th>Staff</th><th>Message</th><th>Photos</th><th>Time</th><th>Action</th></tr></thead>
                        <tbody>
                        @forelse($photoAlerts as $alert)
                            @php
                                $attendanceAlert = $alert->attendance;
                                $action = data_get($alert->data, 'action');
                                $punchPhoto = $action === 'Punch Out' ? $attendanceAlert?->punch_out_photo : $attendanceAlert?->punch_in_photo;
                            @endphp
                            <tr style="opacity:{{ $alert->read_at ? '.65' : '1' }}">
                                <td><span class="{{ data_get($alert->data, 'verification_status') === 'mismatch' ? 'badge-out' : 'badge-done' }}">{{ strtoupper(str_replace('_',' ',data_get($alert->data, 'verification_status','review'))) }}</span></td>
                                <td><strong>{{ $alert->user?->display_name ?? 'Deleted staff' }}</strong><br><span class="muted">{{ $alert->user?->email ?? '-' }}</span></td>
                                <td>{{ $alert->message }}<br><span class="muted">{{ data_get($alert->data, 'reason') }}</span></td>
                                <td><div class="actions">
                                    @if($alert->user?->photo)<a target="_blank" href="{{ asset('storage/'.$alert->user->photo) }}"><img class="worker-photo" src="{{ asset('storage/'.$alert->user->photo) }}" title="Registered photo"></a>@endif
                                    @if($punchPhoto)<a target="_blank" href="{{ asset('storage/'.$punchPhoto) }}"><img class="worker-photo" src="{{ asset('storage/'.$punchPhoto) }}" title="Punch photo"></a>@endif
                                </div></td>
                                <td>{{ $alert->created_at?->format('d M Y h:i A') }}</td>
                                <td>@if(!$alert->read_at)<form method="POST" action="{{ route('admin.notifications.read', $alert) }}">@csrf<button class="btn-ok" type="submit">Mark Read</button></form>@else<span class="badge-done">Read</span>@endif</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;padding:25px" class="muted">No photo verification alerts.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
                    <h3 style="margin:0;font-size:17px">Pending Worker Attendance</h3>
                    <p class="muted" style="margin:5px 0 0">Attendance not yet approved by the Site Supervisor. Admin can approve or reject it here.</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Worker</th><th>Site / Work</th><th>Date</th><th>Time</th><th>Recorded By</th><th>Photo</th><th>Admin Action</th></tr></thead>
                        <tbody>
                        @forelse($pendingWorkerAttendances as $record)
                            <tr>
                                <td><strong>{{ $record->worker?->name ?? 'Deleted worker' }}</strong><br><span class="muted">{{ $record->worker?->worker_code ?? '-' }}</span></td>
                                <td><strong>{{ $record->workSite?->site_name ?? '-' }}</strong><br><span class="muted">{{ $record->siteZone?->zone_name ?? ($record->work_description ?: 'General work') }}</span></td>
                                <td>{{ $record->attendance_date?->format('d M Y') }}</td>
                                <td>{{ $record->punch_in ?: '-' }} — {{ $record->punch_out ?: 'Still inside' }}</td>
                                <td>{{ $record->recordedBy?->name ?? '-' }}</td>
                                <td>@if($record->punch_in_photo)<a href="{{ asset('storage/'.$record->punch_in_photo) }}" target="_blank"><img class="worker-photo" src="{{ asset('storage/'.$record->punch_in_photo) }}" alt="Attendance photo"></a>@else - @endif</td>
                                <td>
                                    <div class="actions">
                                        <form method="POST" action="{{ route('admin.worker-attendance.approve', $record) }}">@csrf<button class="btn-ok" type="submit">Approve</button></form>
                                        <form method="POST" action="{{ route('admin.worker-attendance.reject', $record) }}" class="actions">@csrf<input class="reject-input" name="rejection_reason" maxlength="500" placeholder="Rejection reason" required><button class="btn-reject" type="submit">Reject</button></form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" style="text-align:center;padding:25px" class="muted">No pending worker attendance.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="padding:18px">{{ $pendingWorkerAttendances->withQueryString()->links() }}</div>
            </div>

            <div style="margin-top:24px"><h3 style="margin:0;font-size:17px">Staff Attendance</h3></div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Staff</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Punch In</th>
                                <th>In Location</th>
                                <th>Punch Out</th>
                                <th>Out Location</th>
                                <th>Total Time</th>
                                <th>Photo Verification</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                       <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td>#{{ $attendance->id }}</td>

                                <td><strong>{{ $attendance->user->name }}</strong></td>

                                <td>{{ $attendance->user->email }}</td>

                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>

                                <td>
                                    @if($attendance->punch_in)
                                        {{ \Carbon\Carbon::parse($attendance->punch_in)->format('h:i A') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $attendance->location ?? '-' }}</td>

                                <td>
                                    @if($attendance->punch_out)
                                        {{ \Carbon\Carbon::parse($attendance->punch_out)->format('h:i A') }}
                                    @else
                                        <span class="badge-in">Still In Office</span>
                                    @endif
                                </td>

                                <td>{{ $attendance->punch_out_location ?? '-' }}</td>

                                <td>
                                    @if($attendance->total_minutes)
                                        {{ floor($attendance->total_minutes / 60) }}h
                                        {{ $attendance->total_minutes % 60 }}m
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @php $verifyStatus = $attendance->punch_out ? $attendance->punch_out_verification_status : $attendance->punch_in_verification_status; $verifyScore = $attendance->punch_out ? $attendance->punch_out_match_score : $attendance->punch_in_match_score; @endphp
                                    @if($verifyStatus === 'matched')<span class="badge-in">Verified {{ $verifyScore !== null ? $verifyScore.'%' : '' }}</span>
                                    @elseif($verifyStatus === 'mismatch')<span class="badge-out">Mismatch {{ $verifyScore !== null ? $verifyScore.'%' : '' }}</span>
                                    @elseif($verifyStatus)<span class="badge-done">Review Required</span>
                                    @else - @endif
                                </td>

                                <td>
                                    @if(!$attendance->punch_out)
                                        <span class="badge-in">In Office</span>
                                    @else
                                        <span class="badge-done">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>

                <div style="padding:18px">
                    {{ $attendances->withQueryString()->links() }}
                </div>
            </div>

@endsection
