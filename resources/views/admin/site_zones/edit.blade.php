@extends('layouts.admin')
@section('title','Edit Site Work')
@section('content')
<div class="zone-page"><div class="zone-head"><div><h2>Edit Site Work</h2><p>Update progress, dates, supervisor and work status.</p></div></div><div class="zone-panel"><form method="POST" action="{{ route('admin.site-zones.update',$siteZone) }}">@csrf @method('PUT') @include('admin.site_zones._form',['submitLabel'=>'Save Changes'])</form></div></div>
<style>.zone-head h2{margin:0;color:#fff}.zone-head p{margin:5px 0 16px;color:#8794ac}.zone-panel{padding:20px;border:1px solid #29344d;border-radius:15px;background:#151b29}</style>
@endsection
