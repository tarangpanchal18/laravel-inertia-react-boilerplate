@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    {{ Breadcrumbs::render('dashboard') }}
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop
