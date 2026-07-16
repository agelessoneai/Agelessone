@extends('layouts.app')

@section('content')

<style>
body{background:#0e1320;color:#e8edf6}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:30px!important}
.card-dark{background:#151b29;border:1px solid #262f47;border-radius:18px;padding:25px}
.form-control,.form-select{
    background:#0e1320;
    border:1px solid #262f47;
    color:#fff;
    border-radius:12px;
    padding:12px;
}
.form-control:focus,.form-select:focus{
    background:#0e1320;
    color:#fff;
    border-color:#3f6fe0;
    box-shadow:none;
}
label{margin-bottom:7px;color:#8794ac}
.btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:12px;padding:12px 18px}
.btn-back{border:1px solid #334155;color:#cbd5e1;border-radius:12px;padding:12px 18px;text-decoration:none}
</style>

<div class="card-dark">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Create Complaint Ticket</h3>
            <p class="text-secondary mb-0">Assign park complaint to staff</p>
        </div>

        <a href="{{ route('admin.tickets') }}" class="btn-back">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.tickets.store') }}">
        @csrf

        <div class="mb-3">
            <label>Park Name</label>
            <select name="park_id" class="form-select" required>
                <option value="">Select Park</option>
                @foreach($parks as $park)
                    <option value="{{ $park->id }}">{{ $park->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Assign Staff</label>
            <select name="assigned_to" class="form-select" required>
                <option value="">Select Staff</option>
                @foreach($staff as $person)
                    <option value="{{ $person->id }}">{{ $person->name }} - {{ $person->email }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Item / Ride Name</label>
            <input type="text" name="item_name" class="form-control" placeholder="Example: 12D Theater, Toy Car, Train" required>
        </div>

        <div class="mb-3">
            <label>Complaint Title</label>
            <input type="text" name="complaint_title" class="form-control" placeholder="Example: Motion seat not working" required>
        </div>

        <div class="mb-3">
            <label>Complaint Details</label>
            <textarea name="complaint_description" class="form-control" rows="4" placeholder="Describe the complaint"></textarea>
        </div>

        <div class="mb-4">
            <label>Priority</label>
            <select name="priority" class="form-select" required>
                <option value="low">Low</option>
                <option value="normal" selected>Normal</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
            </select>
        </div>

        <button class="btn-blue" type="submit">
            Assign Ticket
        </button>

    </form>

</div>

@endsection