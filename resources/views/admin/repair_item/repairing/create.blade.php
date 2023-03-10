@extends('layouts.admin_staff')

@section('title')
    Repair Item - Repairing
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.repair_item')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/repair_items/repairing') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Create New Repairing Details </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="form_submit" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 mb-5">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Title
                                        <span class="text-danger">*</span>
                                        <small class="text-info">(Device Name)</small>
                                    </label>
                                    <input type="text" name="title" class="form-control" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold err_title"></span>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Taken Date<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        max="{{ date('Y-m-d') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold err_date"></span>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Customer<span class="text-danger">*</span></label>
                                    <select name="customer" class="form-control disabled-results">
                                        <option value=""></option>
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold err_customer"></span>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Category<span class="text-danger">*</span></label>
                                    <select name="category" class="form-control disabled-results">
                                        <option value=""></option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->category }}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold err_category"></span>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Service Charge<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="service_charge" class="form-control price" value="0"
                                        id="service_charge">

                                    <span class="text-danger font-weight-bold err_service_charge"></span>

                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Note</label>
                                    <textarea name="note" class="form-control"></textarea>

                                    <span class="text-danger font-weight-bold err_note"></span>

                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Product Details</label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-4">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%">Product</th>
                                                <th style="width: 25%">Qty</th>
                                                <th style="width: 25%">Price</th>
                                                <th style="width: 10%" class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="invoice_table_body">
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <select id="product"
                                                            class="form-control disabled-results product">
                                                            <option value=""></option>
                                                            @foreach ($product as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->code . ' - ' . $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <br>
                                                        <span class="text-danger err_product"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control qty" id="qty">
                                                        <span class="text-danger err_qty"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control price" id="price">

                                                        <span class="text-danger err_price"></span>
                                                    </div>
                                                </td>
                                                <td class=" text-center">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary" id="add_button"><i
                                                                class="fa fa-plus"></i></button>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot id="tfoot_data">

                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                        <div class="form-group mb-0 text-right">
                                            <label for="exampleFormControlInput2"
                                                class="font-weight-bold text-black text-right text-uppercase">Sub
                                                Total</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group mb-0">
                                            <input type="text" readonly name="sub_total" id="sub_total"
                                                class="form-control sub_total text-right text-black" value="0"
                                                id="exampleFormControlInput2">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                        <div class="form-group mb-0 text-right">
                                            <label for="exampleFormControlInput2"
                                                class="font-weight-bold text-black text-right text-uppercase">Advance/Paid
                                                Amount<span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group mb-0">
                                            <input type="text" name="paid_amount"
                                                class="form-control price text-right text-black" value="0"
                                                id="paid_amount">

                                            <span class="text-danger font-weight-bold err_paid_amount"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                        <div class="form-group mb-0 text-right">
                                            <label for="exampleFormControlInput2"
                                                class="font-weight-bold text-black text-right text-uppercase">Due
                                                Amount<span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group mb-0">
                                            <input type="text" readonly name="due_amount" placeholder="0.00"
                                                class="form-control price text-right text-black" value="0.00"
                                                id="due_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12 col-12 mb-5" id="submit_button">
                        <div class="form-group text-center text-sm-right">
                            <button type="submit" class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                style="width: 200px">Save</button>
                        </div>
                    </div>

                    <div class="col-lg-12 col-12 mb-5" id="disable_button" style="display: none">
                        <div class="form-group text-center text-sm-right">
                            <button type="button" class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                style="width: 200px"><i class="fas fa-spinner fa-spin"></i> Saving ...</button>
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

            //Main Variable
            var i = 1;
            let total = 0;
            const prduct_arry = [];

            //--------------------- get the Product Information ----------------------
            $('.product').change(function(e) {
                e.preventDefault();

                $('.err_product').text('');
                $('.err_qty').text('');
                $('.err_price').text('');

                var data = {
                    'id': $(this).val()
                }

                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/repair_items/repairing/get_product_info') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        $('#qty').val(response.product.qty)
                        $('#price').val(response.product.price)
                    }
                });
            });
            //-------------------------------- END -----------------------------------

            //Proudct add button validation
            $('#add_button').click(function(e) {
                e.preventDefault();
                i++;
                var product = $('#product').val();
                var data = {
                    'product': product,
                    'qty': $('#qty').val(),
                    'price': $('#price').val(),
                    'prduct_arry': prduct_arry
                }

                if (product == '') {
                    $('.err_product').text('The Product field is required')
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/admin/repair_items/repairing/product_validation') }}",
                        data: data,
                        dataType: "JSON",
                        success: function(response) {

                            $('.err_product').text('');
                            $('.err_qty').text('');
                            $('.err_price').text('');

                            if (response.statuscode == 400) {
                                $.each(response.errors, function(key, item) {
                                    if (key) {
                                        $('.err_' + key).text(item);
                                    } else {
                                        $('.err_' + key).text('');
                                    }
                                });
                            } else if (response.status == false) {
                                $('.err_product').text(response.message);
                            } else {
                                //Clear the Data
                                $('#product').val('').change();
                                $('#qty').val('');
                                $('#price').val('');

                                //Set the product id to prduct_arry
                                prduct_arry[response.data.product_id] = response.data
                                    .product_id;

                                //Append the Invoice Data
                                $('#invoice_table_body').append('<tr id="row_' + i + '">\
                                                    <td>' + response.data.product_name +
                                    ' <input type="hidden" name="product_id[]" id="product_id"  value="' +
                                    response.data.product_id + '"> </td>\
                                                    <td>' + response.data.qty + ' x ' + response.data.priceval +
                                    ' <input type="hidden" name="qty[]"  value="' + response
                                    .data.qty + '"></td>\
                                                    <td>' + response.data.total +
                                    ' <input type="hidden" name="price[]"  value="' +
                                    response.data.price +
                                    '"><input type="hidden" id="amount_val" name="amount"  value="' +
                                    response.data.amount + '"></td>\
                                                    <td><button type="button" class="btn btn-danger remove_button" id="' +
                                    i + '"><i class="fa fa-trash"></i></button></td>\
                                                </tr>');

                                //Service Charge Amount
                                var service_charge = $('#service_charge').val();
                                if (service_charge == "" || service_charge == 0) {
                                    var charge = parseFloat(0);
                                } else {
                                    var charge = parseFloat(service_charge);
                                }

                                total = (total + response.data.amount);
                                var sub_total = (total + charge);
                                $('#sub_total').val(sub_total.toFixed(2));

                                //Paid Amount
                                var paid_amount_val = $('#paid_amount').val();

                                if (paid_amount_val == "" || paid_amount_val == 0) {
                                    var paid_amount = parseFloat(0);
                                } else {
                                    var paid_amount = parseFloat(paid_amount_val);
                                }

                                var due_amount_val = (sub_total - paid_amount);

                                if (due_amount_val <= 0) {
                                    var due_amount = 0;
                                } else {
                                    var due_amount = due_amount_val;
                                }
                                $('#due_amount').val(due_amount.toFixed(2));
                            }
                        }
                    });
                }

            });

            $('#service_charge').keyup(function(e) {
                e.preventDefault();

                var service_charge = $(this).val();

                if (service_charge == "" || service_charge == 0) {
                    var charge = parseFloat(0);
                } else {
                    var charge = parseFloat(service_charge);
                }

                var sub_total = (total + charge);
                $('#sub_total').val(sub_total.toFixed(2));

                //Paid Amount
                var paid_amount_val = $('#paid_amount').val();

                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var due_amount_val = (sub_total - paid_amount);

                if (due_amount_val <= 0) {
                    var due_amount = 0;
                } else {
                    var due_amount = due_amount_val;
                }
                $('#due_amount').val(due_amount.toFixed(2));
            });


            $(document).on('click', '.remove_button', function(e) {
                e.preventDefault();

                var button_id = $(this).attr("id");

                var val = $(this).closest('#row_' + button_id + '').find('#amount_val').val();
                var prouduct_id_ = $(this).closest('#row_' + button_id + '').find('#product_id').val();

                //remove the product id from prduct_arry
                delete prduct_arry[prouduct_id_];

                $('#row_' + button_id + '').remove();

                //Service Charge Amount
                var service_charge = $('#service_charge').val();
                if (service_charge == "" || service_charge == 0) {
                    var charge = parseFloat(0);
                } else {
                    var charge = parseFloat(service_charge);
                }

                total = (total - val);
                var sub_total = (total + charge);
                $('#sub_total').val(sub_total.toFixed(2));

                //Paid Amount
                var paid_amount_val = $('#paid_amount').val();

                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var due_amount_val = (sub_total - paid_amount);

                if (due_amount_val <= 0) {
                    var due_amount = 0;
                } else {
                    var due_amount = due_amount_val;
                }
                $('#due_amount').val(due_amount.toFixed(2));
            });

            function clearError() {
                $('.err_product').text('');
                $('.err_qty').text('');
                $('.err_price').text('');
            }

            function clearFormError() {
                $('.err_customer').text('');
                $('.err_category').text('');
                $('.err_date').text('');
                $('.err_service_charge').text('');
                $('.err_title').text('');
                $('.err_tax_amount').text('');
                $('.err_paid_amount').text('');
            }

            function clearInput() {
                $('#product').val('').change();
                $('#qty').val('');
                $('#price').val('');
            }

            $('#paid_amount').keyup(function(e) {
                e.preventDefault();

                $('.err_paid_amount').text('');

                var paid_amount_val = $(this).val();

               //Service Charge Amount
               var service_charge = $('#service_charge').val();
                if (service_charge == "" || service_charge == 0) {
                    var charge = parseFloat(0);
                } else {
                    var charge = parseFloat(service_charge);
                }

                //Paid amount Validation
                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var subtotal = (total + charge);
                var due_amount_val = (subtotal - paid_amount);

                //Due Amount Validation
                if (due_amount_val < 0) {
                    var due_amount = 0;
                    $('.err_paid_amount').text('Paid Amount must not be grater than ' + subtotal);
                } else if (due_amount_val <= 0) {
                    var due_amount = 0;
                } else {
                    $('.err_paid_amount').text('');
                    var due_amount = due_amount_val;
                }

                $('#due_amount').val(due_amount.toFixed(2));

            });

            //Submit Form
            $('#form_submit').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#form_submit')[0]);

                $.ajax({
                    type: "POST",
                    beforeSend: function() {
                        $('#submit_button').css('display', 'none');
                        $('#disable_button').css('display', 'block');
                    },
                    url: "{{ url('/admin/repair_items/repairing/create') }}",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        clearFormError();
                        $('#submit_button').css('display', 'block');
                        $('#disable_button').css('display', 'none');

                        if (response.statuscode == 400) {
                            $.each(response.errors, function(key, item) {
                                if (key) {
                                    $('.err_' + key).text(item);
                                }
                            });
                        } else if (response.status == false) {
                            $('.err_product').text(response.message);
                        } else {
                            $.confirm({
                                theme: 'modern',
                                columnClass: 'col-md-6 col-12 col-md-offset-4',
                                title: 'Success! ',
                                content: response.message,
                                type: 'green',
                                buttons: {
                                    confirm: {
                                        text: 'OK',
                                        btnClass: 'btn-150',
                                        action: function() {
                                            location.href =
                                                "{{ url('/admin/repair_items/repairing') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

            //Validation
            $(".price").on("input", function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which >
                        57)) {
                    evt.preventDefault();
                }
            });

            $(".qty").on("input", function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9]/g, ''));
                if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which >
                        57)) {
                    evt.preventDefault();
                }
            });
        });
    </script>
@endsection
