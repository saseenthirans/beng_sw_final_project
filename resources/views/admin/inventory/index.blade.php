@extends('layouts.admin.inventory')

@section('title')

    Inventory

@endsection

@section('content')

<div class="col-lg-12 col-12  layout-spacing">
    <a href="{{ url('products/create') }}" class="btn btn-primary float-right text-uppercase"> <i
            class="fa fa-plus"></i> Create
        New</a>
</div>

<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                    <h3 class="font-weight-bold pt-2 pb-2 text-uppercase">Products</h3>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6 m-2">
            <table id="data-table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price </th>
                        <th>Size <small class="text-primary">(ML)</small></th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

@endsection
