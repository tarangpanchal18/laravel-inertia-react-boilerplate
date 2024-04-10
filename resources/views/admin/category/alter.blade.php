@extends('adminlte::page')
@section('title', $action . ' Category')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
    <h1>{{ $action }} Category</h1>
    {{ Breadcrumbs::render('category_alter', $action) }}
@stop

@section('content')
    <div class="card">
        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($action != 'Add') @method('PUT') @endif
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('admin.category.index') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
                </div>
                <p>Please add appropriate details to {{ $action }} Category</p>
            </div>
            <div class="card-body">

                <div class="row">

                    <x-form-input name="name" type="text" label="Category Name" value="{{ $category->name }}" />

                    <x-form-select name="parent_id" label="Parent Category" data="{{ $categoryData->pluck('id','name') }}" value="{{ $category->parent_id }}" />

                    @if ($category->image)
                    <div class="form-group col-md-12">
                        <label>Preview Image</label><br>
                        <img src="{{ asset('storage/uploads/category/' . $category->image) }}" alt="{{ $category->name }}" class="admin-preview img-thumbnail">
                    </div>
                    @endif

                    <div class="form-group col-md-12">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        @error('image')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="statusActive" value="Active" {{ $category->status == "Active" ? 'checked' : '' }} name="status">
                                <label for="statusActive" class="custom-control-label">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="statusInActive" value="InActive" {{ $category->status == "InActive" ? 'checked' : '' }} name="status">
                                <label for="statusInActive" class="custom-control-label">InActive</label>
                            </div>
                        </div>
                        @error('status')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ $action }} Data</button>
                <a href="{{ route('admin.category.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop
