@extends('layouts.app')

@section('content')

@php
    $authUser = Auth::user();
    $words = explode(' ', trim($authUser->name));
    $initials = '';

    foreach($words as $word){
        $initials .= strtoupper(substr($word, 0, 1));
    }

    $initials = substr($initials, 0, 2);
    $roleName = $authUser->role == 'admin' ? 'Administrator' : 'User';
@endphp

<style>
:root{
    --bg:#0e1320;
    --bg2:#0b101b;
    --panel:#151b29;
    --panel2:#1c2436;
    --line:#262f47;
    --txt:#e8edf6;
    --mut:#8794ac;
    --brand:#5b8cff;
    --brand2:#3f6fe0;
    --brand3:#9b6bff;
    --ok:#37c281;
    --crit:#ff5a6e;
}

*{
    box-sizing:border-box;
}

body{
    margin:0;
    background:var(--bg);
    color:var(--txt);
    font-size:14px;
    overflow:hidden;
    font-family:'Segoe UI',system-ui,-apple-system,sans-serif;
}

.navbar,
header{
    display:none!important;
}

.container{
    max-width:100%!important;
    margin:0!important;
    padding:0!important;
}

.app{
    display:grid;
    grid-template-columns:262px 1fr;
    height:100vh;
}

.side{
    background:linear-gradient(180deg,var(--panel),var(--bg2));
    border-right:1px solid var(--line);
    overflow-y:auto;
}

.brand{
    padding:18px;
    display:flex;
    gap:11px;
    align-items:center;
    border-bottom:1px solid var(--line);
}

.logo{
    width:40px;
    height:40px;
    border-radius:11px;
    background:linear-gradient(135deg,var(--brand),var(--brand3));
    display:grid;
    place-items:center;
    font-weight:800;
    font-size:18px;
    color:#fff;
}

.brand h1{
    font-size:15.5px;
    margin:0;
    font-weight:700;
}

.brand p{
    font-size:10px;
    color:var(--mut);
    margin:1px 0 0;
    letter-spacing:.8px;
}

.nav-title{
    padding:18px 23px 8px;
    color:var(--mut);
    font-size:9.5px;
    font-weight:700;
    letter-spacing:1.2px;
    text-transform:uppercase;
}

.nav a{
    display:flex;
    gap:11px;
    align-items:center;
    color:var(--mut);
    padding:8.5px 12px;
    margin:1px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:13.3px;
}

.nav a:hover{
    background:var(--panel2);
    color:var(--txt);
}

.nav a.active{
    background:linear-gradient(90deg,var(--brand2),#3360c8);
    color:#fff;
    font-weight:600;
}

.main{
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.top{
    height:62px;
    background:var(--panel);
    border-bottom:1px solid var(--line);
    display:flex;
    align-items:center;
    padding:0 24px;
    gap:16px;
}

.search{
    width:440px;
    background:var(--bg);
    border:1px solid var(--line);
    border-radius:9px;
    color:var(--txt);
    padding:10px 14px;
    font-size:13px;
}

.user{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    width:36px;
    height:36px;
    border-radius:50%;
    background:linear-gradient(135deg,#5b8cff,#37c281);
    display:grid;
    place-items:center;
    font-weight:700;
    color:#fff;
    font-size:14px;
}

.user strong{
    font-size:14px;
}

.user small{
    font-size:11px;
}

.logout{
    color:#cbd5e1;
    border:1px solid var(--line);
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    background:transparent;
    font-size:13px;
}

.content{
    flex:1;
    overflow-y:auto;
    padding:24px 26px;
}

h2{
    font-size:21px;
    font-weight:700;
    margin:0;
}

.muted{
    color:var(--mut);
}

.page-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.page-head p{
    color:var(--mut);
    font-size:13px;
    margin:3px 0 0;
}

.panel{
    background:var(--panel);
    border:1px solid var(--line);
    border-radius:13px;
    padding:0;
    overflow:hidden;
}

.btn-blue{
    background:linear-gradient(135deg,var(--brand2),#3360c8);
    color:#fff;
    padding:9px 16px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    border:0;
    font-size:13px;
}

.btn-dark-outline{
    color:var(--txt);
    border:1px solid var(--line);
    padding:9px 16px;
    border-radius:8px;
    text-decoration:none;
    background:transparent;
    font-size:13px;
    font-weight:600;
}

.table-responsive{
    overflow-x:auto;
}

.table{
    width:100%;
    color:var(--txt);
    margin-bottom:0;
    border-collapse:collapse;
    font-size:13px;
}

.table thead th{
    background:var(--bg2);
    color:var(--mut);
    border-bottom:1px solid var(--line);
    font-size:10.5px;
    text-transform:uppercase;
    letter-spacing:.5px;
    padding:10px 12px;
    font-weight:600;
}

.table tbody td{
    background:var(--panel);
    color:var(--txt);
    border-bottom:1px solid var(--line);
    padding:11px 12px;
    vertical-align:middle;
}

.table tbody tr:hover td{
    background:var(--panel2);
}

.table tbody tr:last-child td{
    border-bottom:none;
}

.badge-admin{
    background:rgba(255,90,110,.18);
    color:var(--crit);
    padding:3px 9px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.badge-user{
    background:#222c42;
    color:var(--txt);
    padding:3px 9px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.user-name{
    font-weight:650;
}

.user-id{
    color:var(--brand);
    font-family:ui-monospace,'Cascadia Code',monospace;
    font-size:12.3px;
    font-weight:600;
}

.pagination{
    margin:18px;
}

.page-link{
    background:var(--panel)!important;
    border-color:var(--line)!important;
    color:var(--txt)!important;
    font-size:13px;
}

.page-item.active .page-link{
    background:var(--brand2)!important;
    color:#fff!important;
}
</style>

<div class="app">

    <aside class="side">
        <div class="brand">
            <div class="logo">A1</div>
            <div>
                <h1>Ageless One</h1>
                <p>AI BUSINESS SUITE · v1.1</p>
            </div>
        </div>

        <div class="nav-title">OVERVIEW</div>
        <div class="nav">
            <a href="{{ route('admin.dashboard') }}">▦ Executive Dashboard</a>
        </div>

        <div class="nav-title">SERVICE MANAGEMENT</div>

<div class="nav">
    <a href="{{ route('admin.parks') }}">🏢 Parks / Clients</a>
    <a href="{{ route('admin.parks.create') }}">➕ Add Park</a>

    <a href="{{ route('admin.tickets') }}">🎫 Complaint Tickets</a>
    <a href="{{ route('admin.tickets.create') }}">➕ Create Ticket</a>

    <a href="{{ route('admin.spare-parts') }}">📦 Spare Parts</a>
    <a href="{{ route('admin.spare-parts.create') }}">➕ Add Spare Part</a>

    <a href="#">📤 Spare Part Requests</a>
    <a href="#">📄 Service Reports</a>
    <a href="#">⭐ Customer Feedback</a>
    <a href="#">🗺 Live Tracking</a>
</div>


<div class="nav-title">INVENTORY</div>

<div class="nav">
    <a href="#">📦 Stock Dashboard</a>
    <a href="#">📥 Purchase Orders</a>
    <a href="#">🚚 Suppliers</a>
    <a href="#">🔄 Stock In</a>
    <a href="#">📤 Stock Out</a>
    <a href="#">📊 Inventory Reports</a>
</div>


<div class="nav-title">HR & STAFF</div>

<div class="nav">
    <a href="{{ route('admin.attendance') }}">🕒 Attendance</a>
    <a href="{{ route('admin.users') }}">👥 Employees</a>
    <a href="#">💰 Payroll</a>
    <a href="#">🏖 Leave Management</a>
</div>


<div class="nav-title">FINANCE</div>

<div class="nav">
    <a href="#">💵 Accounts</a>
    <a href="#">🧾 Invoices</a>
    <a href="#">💳 Payments</a>
    <a href="#">📈 Expenses</a>
</div>


<div class="nav-title">SALES & CRM</div>

<div class="nav">
    <a href="#">🤝 Customers</a>
    <a href="#">📞 Leads</a>
    <a href="#">📋 Quotations</a>
    <a href="#">📄 Contracts</a>
</div>


<div class="nav-title">REPORTS</div>

<div class="nav">
    <a href="#">📊 Dashboard Reports</a>
    <a href="#">📈 Analytics</a>
    <a href="#">📑 Export Reports</a>
</div>


<div class="nav-title">AI</div>

<div class="nav">
    <a href="#">🤖 ASIM AI Assistant</a>
    <a href="#">💬 AI Chat</a>
</div>


<div class="nav-title">SYSTEM</div>

<div class="nav">
    <a href="#">⚙ Settings</a>
    <a href="#">🔐 Roles & Permissions</a>
    <a href="#">📝 Activity Logs</a>
    <a href="#">💾 Backup & Restore</a>
</div>
<div class="nav">

    <a href="{{ route('admin.attendance') }}">
        🕒 Attendance
    </a>

    <a href="{{ route('admin.users') }}">
        👥 Users
    </a>

    <a href="#">
        ⚙ Settings
    </a>

</div>
    </aside>

    <main class="main">

        <div class="top">
            <input class="search" placeholder="Search users, roles, emails...">

            <div class="user">
                <div class="avatar">{{ $initials }}</div>

                <div>
                    <strong>{{ $authUser->name }}</strong><br>
                    <small class="muted">{{ $roleName }}</small>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout" type="submit">Logout</button>
                </form>
            </div>
        </div>

        <div class="content">

            <div class="page-head">
                <div>
                    <h2>User Management</h2>
                    <p>Manage admins and registered users</p>
                </div>

                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn-dark-outline">Back</a>
                    <a href="{{ route('register') }}" class="btn-blue ms-2">+ Add User</a>
                </div>
            </div>

            <div class="panel">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="user-id">#{{ $user->id }}</td>
                                    <td class="user-name">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge-admin">Administrator</span>
                                        @else
                                            <span class="badge-user">User</span>
                                        @endif
                                    </td>
                                    <td class="muted">{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $users->links() }}

            </div>

        </div>

    </main>

</div>

@endsection