@extends('layouts.admin_staff')

@section('title')
    Inventory
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.inventory')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/inventory/categories') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Update Category </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="categoryCreateForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <input type="hidden" name="id" value="{{$category->id}}">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Category Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="category_name" class="form-control"
                                        value="{{ $category->name }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_category_name"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Upload Category Image <small
                                            class="text-info">(Dimensions (190px x
                                            190px))</small> <span class="text-danger">*</span></label>
                                    <div class="upload">
                                        <input type="file" name="category_image" id="input-file-max-fs" class="dropify"
                                            data-default-file="{{ asset($category->image) }}" data-max-file-size="4M"
                                            accept="image/*" />
                                    </div>
                                    <span class="text-danger font-weight-bold error_category_image"></span>
                                </div>
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="formGroupExampleInput2">Active/Inactive</label>
                                <div>
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input type="checkbox" name="status" {{ $category->status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class=" col-lg-12 col-12 border-top">
                                <div class="row mt-3">
                                    <div class="form-group col-lg-6 col-6">
                                        <label for="formGroupExampleInput2">Display on Home Page?</label>
                                        <div>
                                            <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                                <input type="checkbox" name="is_home" onclick='handleClick(this);'
                                                    {{ $category->is_home == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6 col-6"></div>
                                    <div class="banner_div col-lg-12" id="banner_div" style="{{ $category->is_home == 1 ? "display: block" : "display: none" }}"  >
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group mb-4">
                                                    <label for="exampleFormControlInput2">Banner Title<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="banner_title" class="form-control"
                                                        value="{{ $category->banner_title }}" id="exampleFormControlInput2">
                                                    <span class="text-danger font-weight-bold error_banner_title"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12">
                                                <div class="form-group mb-4">

                                                    <label for="exampleFormControlInput2">Upload banner Image <small
                                                            class="text-info">(Dimensions (900px x
                                                            300px))</small> <span class="text-danger">*</span></label>
                                                    <div class="upload">
                                                        <input type="file" name="banner_image" id="input-file-max-fs"
                                                            class="dropify"
                                                            data-default-file="{{ asset($category->banner_image) }}"
                                                            data-max-file-size="4M" accept="image/*" />
                                                    </div>
                                                    <span class="text-danger font-weight-bold error_banner_image"></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5">
                                <div class="form-group text-center text-sm-right">
                                    <button type="submit"
                                        class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin_staff/vendors/common/inventory.js') }}"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#categoryCreateForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#categoryCreateForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/inventory/categories/update') }}",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.statuscode == 400) {
                            $.each(response.errors, function(key, item) {
                                if (key) {
                                    $('.error_' + key).text(item);
                                } else {
                                    $('.error_' + key).text('');
                                }
                            });
                        } else {
                            $.confirm({
                                theme: 'modern',
                                columnClass: 'col-md-6 col-8 col-md-offset-4',
                                title: 'Success! ',
                                content: response.message,
                                type: 'green',
                                buttons: {
                                    confirm: {
                                        text: 'OK',
                                        btnClass: 'btn-150',
                                        action: function() {
                                            location.href =
                                                "{{ url('/admin/inventory/categories') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

        });
    </script>
@endsection
