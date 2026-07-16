@extends('layouts.app')

@section('content')

<style>
body{margin:0;background:#0e1320;color:#e8edf6;overflow:hidden;font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:0!important}

.app{display:grid;grid-template-columns:270px 1fr;height:100vh}
.side{background:#151b29;border-right:1px solid #262f47}
.brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
.logo{
width:48px;
height:48px;
border-radius:14px;
background:linear-gradient(135deg,#5b8cff,#9b6bff);
display:grid;
place-items:center;
font-weight:800;
font-size:22px;
color:#fff;
}
.brand h1{margin:0;font-size:17px}
.brand p{margin:0;font-size:11px;color:#8794ac}

.nav-title{
padding:18px 24px 8px;
font-size:11px;
color:#8794ac;
font-weight:700;
letter-spacing:1px;
}

.nav a{
display:flex;
padding:14px 22px;
text-decoration:none;
color:#a8b4cc;
}

.nav a.active{
background:#3f6fe0;
color:#fff;
border-radius:0 12px 12px 0;
}

.main{overflow:auto}

.top{
height:76px;
background:#151b29;
display:flex;
align-items:center;
padding:0 30px;
border-bottom:1px solid #262f47;
}

.search{
width:450px;
padding:13px;
background:#0e1320;
border:1px solid #262f47;
border-radius:12px;
color:#fff;
}

.user{
margin-left:auto;
display:flex;
align-items:center;
gap:12px;
}

.avatar{
width:46px;
height:46px;
border-radius:50%;
background:linear-gradient(135deg,#5b8cff,#37c281);
display:grid;
place-items:center;
font-weight:700;
color:#fff;
}

.logout{
background:transparent;
border:1px solid #334155;
padding:10px 18px;
color:#fff;
border-radius:10px;
}

.content{
padding:30px;
}

.card-dark{
background:#151b29;
border:1px solid #262f47;
border-radius:18px;
padding:30px;
}

label{
color:#8794ac;
margin-bottom:7px;
font-size:13px;
}

.form-control{
background:#0e1320;
border:1px solid #262f47;
color:#fff;
border-radius:12px;
padding:13px;
}

.form-control:focus{
background:#0e1320;
border-color:#3f6fe0;
color:#fff;
box-shadow:none;
}

.btn-blue{
background:#3f6fe0;
color:#fff;
border:0;
padding:12px 22px;
border-radius:12px;
font-weight:700;
}

.btn-back{
border:1px solid #334155;
padding:12px 22px;
border-radius:12px;
text-decoration:none;
color:#fff;
}

.muted{
color:#8794ac;
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
            <a href="{{ route('admin.dashboard') }}">
                🏠 Executive Dashboard
            </a>
        </div>

        <div class="nav-title">SERVICE MANAGEMENT</div>

        <div class="nav">

            <a href="{{ route('admin.parks') }}">
                🏢 Parks / Clients
            </a>

            <a class="active"
               href="{{ route('admin.parks.create') }}">
                ➕ Add Park
            </a>

            <a href="{{ route('admin.tickets') }}">
                🎫 Complaint Tickets
            </a>

            <a href="{{ route('admin.tickets.create') }}">
                ➕ Create Ticket
            </a>

        </div>

        <div class="nav-title">ADMIN</div>

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

            <input class="search"
                   placeholder="Search parks...">

            <div class="user">

                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>

                <div>
                    <strong>{{ Auth::user()->name }}</strong><br>
                    <small class="muted">
                        Administrator
                    </small>
                </div>

                <form method="POST"
                      action="{{ route('logout') }}">
                    @csrf
                    <button class="logout">
                        Logout
                    </button>
                </form>

            </div>

        </div>

        <div class="content">

            <div class="card-dark">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h2>Add Park / Client</h2>
                        <p class="muted mb-0">
                            Register a new customer park
                        </p>
                    </div>

                    <a href="{{ route('admin.parks') }}"
                       class="btn-back">
                        Back
                    </a>

                </div>

                <form method="POST"
                      action="{{ route('admin.parks.store') }}">

                    @csrf

                    <div class="mb-3">
                        <label>Park / Client Name *</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Wonder World Park"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Contact Person</label>

                        <input type="text"
                               name="contact_person"
                               class="form-control"
                               placeholder="Manager Name">
                    </div>

                    <div class="mb-3">
                        <label>Phone Number</label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="9876543210">
                    </div>

                    <div class="mb-4">
                        <label>Location</label>

                        <input type="text"
                               name="location"
                               class="form-control"
                               placeholder="Kochi, Kerala">
                    </div>

                    <button class="btn-blue">
                        Save Park
                    </button>

                </form>

            </div>

        </div>

    </main>

</div>

@endsection