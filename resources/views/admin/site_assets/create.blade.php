@extends('layouts.admin')
@section('title','Add Site Asset')
@section('page-title','Add Site Asset')
@section('content')
@include('admin.site_assets.partials.form',['siteAsset'=>null,'action'=>route('admin.site-assets.store'),'method'=>'POST'])
@endsection
