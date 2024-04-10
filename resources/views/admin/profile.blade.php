@extends('adminlte::page')
@section('title', 'My Profile')
@section('plugins.Sweetalert2', true)
@section('plugins.CustomAdmin', true)

@section('content_header')
    <h1>Manage Your Profile</h1>
    {{ Breadcrumbs::render('profile') }}
@stop

@section('content')
    <div class="card">

        @include('layouts.alert-msg')

        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
                <p>Manage Your Profile here</p>
            </div>
            <div class="card-body">
                <div class="row">

                    <x-form-input name="name" type="text" label="Your Name" value="{{ $user->name }}" />

                    <x-form-input name="email" type="email" label="Your Email" value="{{ $user->email }}" />

                    <x-form-input name="password" type="password" label="Your Password" />

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update Profile</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('js')
<x-alert-msg />
@stop
