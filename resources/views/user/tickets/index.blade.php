@extends('layouts.app')

@section('content')

@php
$user = Auth::user();
$initials = strtoupper(substr($user->name,0,1));
@endphp

<style>

    .tabs{
    display:flex;
    gap:8px;
    overflow-x:auto;
    margin-bottom:18px;
    padding-bottom:4px;
}

.tabs a{
    white-space:nowrap;
    background:var(--card);
    border:1px solid var(--line);
    color:var(--muted);
    text-decoration:none;
    padding:10px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.tabs a.active{
    background:linear-gradient(135deg,var(--blue),var(--purple));
    color:#fff;
    border-color:transparent;
}
:root{--bg:#0e1320;--card:#151b29;--card2:#1c2436;--line:#262f47;--text:#e8edf6;--muted:#8794ac;--blue:#3f6fe0;--purple:#9b6bff;--green:#37c281;--red:#ff5a6e;--orange:#f2b53b}
body{margin:0;background:var(--bg);color:var(--text);font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}.container{max-width:100%!important;padding:0!important;margin:0!important}
.mobile-app{min-height:100vh;padding:18px;padding-bottom:90px;background:radial-gradient(circle at top right,rgba(91,140,255,.25),transparent 30%),var(--bg)}
.app-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.profile{display:flex;align-items:center;gap:12px}.avatar{width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,var(--blue),var(--purple));display:grid;place-items:center;font-weight:800}
.profile h3{font-size:18px;margin:0}.profile p{margin:2px 0 0;color:var(--muted);font-size:12px}
.logout{background:var(--card);border:1px solid var(--line);color:#fff;border-radius:14px;padding:10px 14px}
.title{font-size:24px;font-weight:800;margin:8px 0 4px}.sub{color:var(--muted);font-size:13px;margin-bottom:18px}
.ticket-card{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:18px;margin-bottom:16px}
.ticket-top{display:flex;justify-content:space-between;gap:10px;margin-bottom:12px}
.ticket-no{font-weight:800;color:#fff}.date{color:var(--muted);font-size:12px}
.badge{padding:6px 10px;border-radius:999px;font-size:11px;font-weight:800}
.priority-low{background:rgba(135,148,172,.18);color:var(--muted)}
.priority-normal{background:rgba(91,140,255,.18);color:#8fb0ff}
.priority-high{background:rgba(242,181,59,.18);color:var(--orange)}
.priority-urgent{background:rgba(255,90,110,.18);color:var(--red)}
.status{background:var(--card2);color:#fff}
.info{margin-top:12px}.info span{display:block;color:var(--muted);font-size:12px;margin-bottom:3px}.info b{font-size:15px}
.actions{margin-top:16px;display:grid;gap:10px}
.btn-green,.btn-blue,.btn-red{border:0;border-radius:16px;padding:14px;color:#fff;font-weight:800;width:100%}
.btn-green{background:linear-gradient(135deg,var(--green),#22c55e)}
.btn-blue{background:linear-gradient(135deg,var(--blue),var(--purple))}
.btn-red{background:linear-gradient(135deg,var(--red),#ef4444)}
.empty{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:28px;text-align:center;color:var(--muted)}
.bottom-nav{position:fixed;left:12px;right:12px;bottom:12px;background:rgba(21,27,41,.95);border:1px solid var(--line);border-radius:24px;display:grid;grid-template-columns:repeat(4,1fr);padding:10px 6px}
.bottom-nav a{text-align:center;color:var(--muted);text-decoration:none;font-size:11px}.bottom-nav a.active{color:#fff}.bottom-nav i{display:block;font-style:normal;font-size:20px;margin-bottom:3px}
@media(min-width:768px){.mobile-app{max-width:430px;margin:auto}.bottom-nav{max-width:406px;margin:auto;left:0;right:0}}
</style>

<div class="mobile-app">

    <div class="app-header">
        <div class="profile">
            <div class="avatar">{{ $initials }}</div>
            <div>
                <h3>{{ $user->name }}</h3>
                <p>Staff Service Panel</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </div>

    <div class="title">My Tickets</div>
    <div class="tabs">
    <a href="{{ route('staff.tickets') }}" class="{{ request('status') == '' ? 'active' : '' }}">All</a>
    <a href="{{ route('staff.tickets', ['status'=>'pending']) }}" class="{{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
    <a href="{{ route('staff.tickets', ['status'=>'accepted']) }}" class="{{ request('status') == 'accepted' ? 'active' : '' }}">Accepted</a>
    <a href="{{ route('staff.tickets', ['status'=>'work_started']) }}" class="{{ request('status') == 'work_started' ? 'active' : '' }}">Working</a>
    <a href="{{ route('staff.tickets', ['status'=>'need_spare_parts']) }}" class="{{ request('status') == 'need_spare_parts' ? 'active' : '' }}">Spare</a>
    <a href="{{ route('staff.tickets', ['status'=>'completed']) }}" class="{{ request('status') == 'completed' ? 'active' : '' }}">Done</a>
</div>

    @forelse($tickets as $ticket)

        <div class="ticket-card">

            <div class="ticket-top">
                <div>
                    <div class="ticket-no">{{ $ticket->ticket_no }}</div>
                    <div class="date">{{ $ticket->created_at->format('d M Y h:i A') }}</div>
                </div>

                <span class="badge priority-{{ $ticket->priority }}">
                    {{ ucfirst($ticket->priority) }}
                </span>
            </div>

            <span class="badge status">
                {{ str_replace('_',' ',ucfirst($ticket->status)) }}
            </span>

            <div class="info">
                <span>Park</span>
                <b>{{ $ticket->park->name }}</b>
            </div>

            <div class="info">
                <span>Item / Ride</span>
                <b>{{ $ticket->item_name }}</b>
            </div>

            <div class="info">
                <span>Complaint</span>
                <b>{{ $ticket->complaint_title }}</b>
            </div>

            @if($ticket->complaint_description)
                <div class="info">
                    <span>Details</span>
                    <b>{{ $ticket->complaint_description }}</b>
                </div>
            @endif

           <div class="actions">
            @if($ticket->status == 'accepted' && $ticket->travel_status != 'travelling')
    <button class="btn-blue" type="button" onclick="startTravel({{ $ticket->id }})">
        🚗 Start Travel
    </button>
@endif

@if($ticket->travel_status == 'travelling')
    <button class="btn-green" type="button" onclick="markArrived({{ $ticket->id }})">
        📍 Mark Arrived
    </button>
@endif

    @if($ticket->status == 'pending')
        <form method="POST" action="{{ route('tickets.accept',$ticket->id) }}">
            @csrf
            <button class="btn-green">✅ Accept Job</button>
        </form>
    @endif

    @if($ticket->status == 'accepted')
        <form method="POST" action="{{ route('tickets.start',$ticket->id) }}">
            @csrf
            <button class="btn-blue">▶ Start Work</button>
        </form>
    @endif

    @if(in_array($ticket->status, ['work_started','need_spare_parts']))

        <form method="POST" action="{{ route('tickets.update',$ticket->id) }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="update_type" value="progress">

            <textarea name="note" class="mobile-input" rows="3" placeholder="Work progress note"></textarea>

            <input type="file" name="image" class="mobile-input" accept="image/*" capture="environment">

            <button class="btn-blue">📝 Add Progress Update</button>
        </form>

        <form method="POST" action="{{ route('tickets.update',$ticket->id) }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="update_type" value="spare_parts">

            <input type="text" name="spare_parts" class="mobile-input" placeholder="Required spare parts">

            <textarea name="note" class="mobile-input" rows="2" placeholder="Reason / details"></textarea>

            <input type="file" name="image" class="mobile-input" accept="image/*" capture="environment">

            <button class="btn-red">📦 Request Spare Parts</button>
        </form>

        <form method="POST" action="{{ route('tickets.complete',$ticket->id) }}" enctype="multipart/form-data">
            @csrf

            <textarea name="note" class="mobile-input" rows="3" placeholder="Completion note" required></textarea>

            <input type="file" name="image" class="mobile-input" accept="image/*" capture="environment">

            <button class="btn-green">✅ Complete Ticket</button>
        </form>

    @endif

</div>

<style>
    .mobile-input{
    width:100%;
    background:var(--card2);
    border:1px solid var(--line);
    color:#fff;
    border-radius:16px;
    padding:13px;
    margin-bottom:10px;
    font-size:14px;
}

.mobile-input::placeholder{
    color:var(--muted);
}
</style>

        </div>

    @empty
        <div class="empty">
            No tickets assigned yet.
        </div>
    @endforelse

</div>

<div class="bottom-nav">
    <a href="{{ route('user.dashboard') }}"><i>🏠</i>Home</a>
    <a href="{{ route('staff.tickets') }}" class="active"><i>🎫</i>Tickets</a>
    <a href="#"><i>👤</i>Profile</a>
    <a href="#"><i>⚙</i>Settings</a>
</div>
<script>
let watchId = null;

function startTravel(ticketId){
    fetch(`/tickets/${ticketId}/travel/start`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    }).then(() => {
        alert("Travel started. Live tracking enabled.");

        watchId = navigator.geolocation.watchPosition(function(position){
            fetch(`/tickets/${ticketId}/travel/location`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                })
            });
        }, function(){
            alert("Please allow location permission.");
        }, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 15000
        });

        setTimeout(() => location.reload(), 1000);
    });
}

function markArrived(ticketId){
    fetch(`/tickets/${ticketId}/travel/arrived`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    }).then(() => {
        if(watchId){
            navigator.geolocation.clearWatch(watchId);
        }

        alert("Marked as arrived.");
        location.reload();
    });
}
</script>
@endsection