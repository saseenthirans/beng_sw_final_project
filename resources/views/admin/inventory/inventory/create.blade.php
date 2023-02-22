@extends('layouts.admin_staff')

@section('title')
    Inventory - Inventories
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.inventory')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/inventory/inventories') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Create New Inventory </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Product Code<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="product_code" class="form-control"
                                        value="{{ old('product_code') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_product_code"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Product Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="product_name" class="form-control"
                                        value="{{ old('product_name') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_product_name"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Category<span class="text-danger">*</span></label>
                                    <select name="category" class="form-control disabled-results category">
                                        <option value=""></option>
                                        @foreach ($categories as $item)
                                            <optgroup label="{{$item->name}}">
                                                @foreach ($item->activeSubCategory as $acItem)
                                                    <option class="ml-4" value="{{ $acItem->id }}">{{ $acItem->name }}</option>
                                                @endforeach
                                            </optgroup>

                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold error_category"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Selling Price<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="selling_price" class="form-control price"
                                        value="{{ old('selling_price') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_selling_price"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Sort Description<span
                                            class="text-danger">*</span></label>
                                    <textarea name="sort_description" class="form-control" rows="3"></textarea>
                                    <span class="text-danger font-weight-bold error_sort_description"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Full Description<span
                                            class="text-danger">*</span></label>
                                        <textarea name="full_description" class="form-control summernote" rows="3"></textarea>
                                    <span class="text-danger font-weight-bold error_full_description"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Upload Image <small
                                            class="text-info">(Dimensions (800px x
                                            900px))</small> <span class="text-danger">*</span></label>
                                    <div class="upload">
                                        <input type="file" name="image" id="input-file-max-fs" class="dropify"
                                            {{-- data-default-file="{{ asset(Auth::user()->UserProfile->profile) }}" --}} data-max-file-size="4M" accept="image/*" />
                                    </div>
                                    <span class="text-danger font-weight-bold error_image"></span>
                                </div>
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="formGroupExampleInput2">Active/Inactive</label>
                                <div>
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input type="checkbox" name="status" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5" id="submit_button">
                                <div class="form-group text-center text-sm-right">
                                    <button type="submit"
                                        class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px">Save</button>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5" id="disable_button" style="display: none">
                                <div class="form-group text-center text-sm-right">
                                    <button type="button"
                                        class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px"><i class="fas fa-spinner fa-spin"></i> Saving ...</button>
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
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submitForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#submitForm')[0]);

                $.ajax({
                    type: "POST",
                    beforeSend: function() {
                        $('#submit_button').css('display', 'none');
                        $('#disable_button').css('display', 'block');
                    },
                    url: "{{ url('/admin/inventory/inventories/create') }}",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $('#submit_button').css('display', 'block');
                        $('#disable_button').css('display', 'none');

                        clearForm();
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
                                                "{{ url('/admin/inventory/inventories') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

            function clearForm()
            {
                $('.error_product_code').text('');
                $('.error_product_name').text('');
                $('.error_category').text('');
                $('.error_selling_price').text('');
                $('.error_sort_description').text('');
                $('.error_full_description').text('');
                $('.error_image').text('');
            }

            $(".price").on("input", function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which >
                        57)) {
                    evt.preventDefault();
                }
            });

        });
    </script>
@endsection
