@extends('layouts.admin_staff')

@section('title')
    Inventory - Sales
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.inventory')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/inventory/sales') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Update Sale </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">
                            <input type="hidden" name="id" value="{{$sale->id}}" id="">
                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Select Product<span class="text-danger">*</span></label>
                                    <select name="product_id" class="form-control disabled-results product_id">
                                        <option value=""></option>
                                        @foreach ($inventory as $item)
                                            <option class="ml-4" value="{{ $item->id }}" {{$sale->inv_id == $item->id ? 'selected' : ''}}>{{ $item->code.' - ' . $item->name }}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold error_product_id"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Selling Price<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="selling_price" class="form-control selling_price price text-black"
                                        value="{{ $sale->inventory->price }}" readonly id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_selling_price"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Sale Type<span
                                            class="text-danger">*</span></label>
                                    <select name="sale_type" class="form-control">
                                        <option value=""></option>
                                        <option value="1" {{$sale->sale_type == 1 ? 'selected' : ''}}>Percentage</option>
                                        <option value="2" {{$sale->sale_type == 2 ? 'selected' : ''}}>Amount</option>
                                    </select>

                                    <span class="text-danger font-weight-bold error_sale_type"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Amount<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="amount" class="form-control"
                                        value="{{ $sale->amount }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_amount"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Start Date<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="start_date" min="{{$sale->start_date}}" class="form-control"
                                        value="{{ $sale->start_date }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_start_date"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">End Date<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="end_date" min="{{$sale->start_date}}" class="form-control"
                                        value="{{ $sale->end_date }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_end_date"></span>
                                </div>
                            </div>


                            <div class="col-lg-12 col-12 mb-5" id="submit_button">
                                <div class="form-group text-center text-sm-right">
                                    <button type="submit"
                                        class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px">Update</button>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5" id="disable_button" style="display: none">
                                <div class="form-group text-center text-sm-right">
                                    <button type="button"
                                        class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px"><i class="fas fa-spinner fa-spin"></i> Updating ...</button>
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
                    url: "{{ url('/admin/inventory/sales/update') }}",
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
                        }
                        else if(response.status == false)
                        {
                            $('.error_product_id').text(response.message);
                        }
                        else {
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
                                                "{{ url('/admin/inventory/sales') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

            $('.product_id').change(function (e) {
                e.preventDefault();
                var id = $(this).val();

                var data = {
                    'id' : id
                }

                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/inventory/sales/getprice') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        $('.selling_price').val(response.inventory.price)
                    }
                });
            });

            function clearForm()
            {
                $('.error_product_id').text('');
                $('.error_sale_type').text('');
                $('.error_amount').text('');
                $('.error_start_date').text('');
                $('.error_end_date').text('');
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
