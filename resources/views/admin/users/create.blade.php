@extends('layouts.admin')
@section('title','Add Office Staff')
@section('page-title','Add Office Staff')
@section('content')
<div class="card card-dark p-4"><form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">@csrf @include('admin.users._form')<div class="mt-4"><a class="btn btn-outline-light" href="{{ route('admin.users.index') }}">Cancel</a><button class="btn btn-primary">Create Staff</button></div></form></div>
@endsection
