@extends('adminlte::page')
@section('title', 'Page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Page</h1>

{{ Breadcrumbs::render('page_list') }}
@stop

@section('content')
<div class="card">
    <form action="{{route('admin.pages.index')}}">
        <div class="card-body row">
            <div class="form-group col-md-3">
                <label>Filter By Status</label>
                <select name="status" id="filter_status" class="form-control select2">
                    <option value="">Select Status</option>
                    <option {{ request()->query('status') == "Active" ? 'selected' : '' }} value="Active">Filter By Active</option>
                    <option {{ request()->query('status') == "InActive" ? 'selected' : '' }} value="InActive">Filter By InActive</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-default filter-search"><i class="fa fa-search"></i> Search</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-default filter-search"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Page Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Page Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<x-alert-msg />
<script>
    $(document).ready(function() {
        console.log($("#user_id").val())
        generateDataTable('{{ route("admin.pages.index") }}', [{
                data: 'DT_RowIndex',
                name: 'id',
                orderable: false,
                searchable: false
            },
            {
                data: 'page_name',
                name: 'page_name',
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ], {
            'status': $("#filter_status").val(),
        }, [0, 1, 2], false);

    });

    function removeData(id) {
        removeDataFromDatabase('{{route("admin.pages.index")}}', id);
    }
</script>
@stop
