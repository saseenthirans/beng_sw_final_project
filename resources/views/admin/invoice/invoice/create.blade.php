@extends('layouts.admin_staff')

@section('title')
    Invoice - Invoice
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.invoice')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/invoices/invoices') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Create New Invoice </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="form_submit" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Date<span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date') }}"
                                        max="{{ date('Y-m-d') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold err_date"></span>

                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
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

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Tax Amount<span
                                            class="text-danger">*</span></label>

                                    <input type="text" name="tax_amount" class="form-control price" value="0"
                                        id="tax_amount">

                                    <span class="text-danger font-weight-bold err_tax_amount"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Discount (%)<span
                                            class="text-danger">*</span></label>

                                    <input type="text" name="discount" class="form-control" value="0" max="100"
                                        id="discount">

                                    <span class="text-danger font-weight-bold err_discount"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Payment Type<span
                                            class="text-danger">*</span></label>
                                    <select name="pay_type" class="form-control disabled-results">
                                        <option value=""></option>
                                        @foreach ($pay_type as $item)
                                            <option value="{{ $item->id }}">{{ $item->method }}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold err_pay_type"></span>

                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Total Amount<span
                                            class="text-danger">*</span></label>

                                    <input type="text" readonly name="total_amount" id="total_amount"
                                        placeholder="0.00" class="form-control price" value="0.00">
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Paid Amount<span
                                            class="text-danger">*</span></label>

                                    <input type="text" name="paid_amount" class="form-control price" value="0"
                                        id="paid_amount">

                                    <span class="text-danger font-weight-bold err_paid_amount"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Due Amount<span
                                            class="text-danger">*</span></label>

                                    <input type="text" readonly name="due_amount" placeholder="0.00"
                                        class="form-control price" value="0.00" id="due_amount">
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="col-lg-12 col-12 mb-5" id="submit_button">
                        <div class="form-group text-center text-sm-right">
                            <button type="submit" class="btn btn-primary btn-max-200 text-uppercase font-weight-bold"
                                style="width: 200px">Save</button>
                        </div>
                    </div>

                    <div class="col-lg-12 col-12 mb-5" id="disable_button" style="display: none">
                        <div class="form-group text-center text-sm-right">
                            <button type="button" class="btn btn-primary btn-max-200 text-uppercase font-weight-bold"
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
                    url: "{{ url('/admin/invoices/invoices/get_product_info') }}",
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
                    'prduct_arry' : prduct_arry
                }

                if (product == '') {
                    $('.err_product').text('The Product field is required')
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/admin/invoices/invoices/product_validation') }}",
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
                            }
                            else if(response.status == false)
                            {
                                $('.err_product').text(response.message);
                            }
                            else {
                                //Clear the Data
                                $('#product').val('').change();
                                $('#qty').val('');
                                $('#price').val('');

                                //Set the product id to prduct_arry
                                prduct_arry[response.data.product_id] = response.data.product_id;

                                //Append the Invoice Data
                                $('#invoice_table_body').append('<tr id="row_' + i + '">\
                                        <td>' + response.data.product_name +
                                    ' <input type="hidden" name="product_id[]" id="product_id"  value="' +
                                    response.data.product_id + '"> </td>\
                                        <td>' + response.data.qty + ' x ' + response.data.priceval +
                                    ' <input type="hidden" name="qty[]"  value="' + response
                                    .data.qty + '"></td>\
                                        <td>' + response.data.total + ' <input type="hidden" name="price[]"  value="' +
                                    response.data.price +
                                    '"><input type="hidden" id="amount_val" name="amount"  value="' +
                                    response.data.amount + '"></td>\
                                        <td><button type="button" class="btn btn-danger remove_button" id="' + i + '"><i class="fa fa-trash"></i></button></td>\
                                    </tr>');

                                total = (total + response.data.amount);
                                $('#tfoot_data').html('');
                                $('#tfoot_data').append('<tr>\
                                        <td colspan="2"> </td>\
                                        <td colspan="2">' + total.toFixed(2) + ' </td>\
                                    </tr>');

                                var tax_amount = $('#tax_amount').val();
                                var discount_val = $('#discount').val();
                                var paid_amount_val = $('#paid_amount').val();

                                //Tax amount Validation
                                if (tax_amount == "" || tax_amount == 0) {
                                    var tax = parseFloat(0);
                                } else {
                                    var tax = parseFloat(tax_amount);
                                }

                                //Discount Validation
                                if (discount_val == "" || discount_val == 0) {
                                    var discount = parseInt(0);
                                } else {
                                    var discount = parseInt(discount_val);
                                }

                                //Paid amount Validation
                                if (paid_amount_val == "" || paid_amount_val == 0) {
                                    var paid_amount = parseFloat(0);
                                } else {
                                    var paid_amount = parseFloat(paid_amount_val);
                                }

                                var amount = (total + tax);
                                var total_amount = (amount - (amount * discount) / 100);
                                var due_amount_val = (total_amount - paid_amount);

                                //Due Amount Validation
                                if (due_amount_val <= 0) {
                                    var due_amount = 0;
                                } else {
                                    var due_amount = due_amount_val;
                                }
                                $('#total_amount').val(total_amount.toFixed(2));
                                $('#due_amount').val(due_amount.toFixed(2));
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.remove_button', function(e) {
                e.preventDefault();

                var button_id = $(this).attr("id");

                var val = $(this).closest('#row_' + button_id + '').find('#amount_val').val();
                var prouduct_id_ = $(this).closest('#row_' + button_id + '').find('#product_id').val();

                //remove the product id from prduct_arry
                delete prduct_arry[prouduct_id_];

                $('#row_' + button_id + '').remove();

                total = (total - val);
                $('#tfoot_data').html('');
                $('#tfoot_data').append('<tr>\
                            <td colspan="2"> </td>\
                            <td colspan="2">' + total.toFixed(2) + ' </td>\
                        </tr>');

                var tax_amount = $('#tax_amount').val();
                var discount_val = $('#discount').val();
                var paid_amount_val = $('#paid_amount').val();

                //Tax amount Validation
                if (tax_amount == "" || tax_amount == 0) {
                    var tax = parseFloat(0);
                } else {
                    var tax = parseFloat(tax_amount);
                }

                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                } else {
                    var discount = parseInt(discount_val);
                }

                //Paid amount Validation
                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var amount = (total + tax);
                var total_amount = (amount - (amount * discount) / 100);
                var due_amount_val = (total_amount - paid_amount);

                //Due Amount Validation
                if (due_amount_val <= 0) {
                    var due_amount = 0;
                } else {
                    var due_amount = due_amount_val;
                }
                $('#total_amount').val(total_amount.toFixed(2));
                $('#due_amount').val(due_amount.toFixed(2));
            });

            function clearError() {
                $('.err_product').text('');
                $('.err_qty').text('');
                $('.err_price').text('');
            }

            function clearFormError() {
                $('.err_customer').text('');
                $('.err_date').text('');
                $('.err_pay_type').text('');
                $('.err_discount').text('');
                $('.err_tax_amount').text('');
                $('.err_paid_amount').text('');
            }

            function clearInput() {
                $('#product').val('').change();
                $('#qty').val('');
                $('#price').val('');
            }

            $('#tax_amount').keyup(function(e) {
                e.preventDefault();

                $('.err_tax_amount').text('');

                var tax_amount = $(this).val();
                var discount_val = $('#discount').val();
                var paid_amount_val = $('#paid_amount').val();

                //Tax amount Validation
                if (tax_amount == "" || tax_amount == 0) {
                    var tax = parseFloat(0);
                } else {
                    var tax = parseFloat(tax_amount);
                }

                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                } else {
                    var discount = parseInt(discount_val);
                }

                //Paid amount Validation
                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var amount = (total + tax);
                var total_amount = (amount - (amount * discount) / 100);
                var due_amount_val = (total_amount - paid_amount);

                //Due Amount Validation
                if (due_amount_val <= 0) {
                    var due_amount = 0;
                } else {
                    var due_amount = due_amount_val;
                }
                $('#total_amount').val(total_amount.toFixed(2));
                $('#due_amount').val(due_amount.toFixed(2));

            });

            $('#discount').keyup(function(e) {
                e.preventDefault();

                $('.err_discount').text('');

                var tax_amount = $('#tax_amount').val();
                var discount_val = $(this).val();
                var paid_amount_val = $('#paid_amount').val();

                if (discount_val > 100) {
                    discount_val = 100;
                    $('#discount').val(discount_val);
                } else {
                    discount_val = discount_val;
                }

                //Tax amount Validation
                if (tax_amount == "" || tax_amount == 0) {
                    var tax = parseFloat(0);
                } else {
                    var tax = parseFloat(tax_amount);
                }

                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                    $('#discount').val(discount);
                } else {
                    var discount = parseInt(discount_val);
                }

                //Paid amount Validation
                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                    $('#paid_amount').val(paid_amount);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var amount = (total + tax);
                var total_amount = (amount - (amount * discount) / 100);
                var due_amount_val = (total_amount - paid_amount);

                //Due Amount Validation
                if (due_amount_val <= 0) {
                    var due_amount = 0;
                } else {
                    var due_amount = due_amount_val;
                }
                $('#total_amount').val(total_amount.toFixed(2));
                $('#due_amount').val(due_amount.toFixed(2));

            });

            $('#paid_amount').keyup(function(e) {
                e.preventDefault();

                $('.err_paid_amount').text('');

                var tax_amount = $('#tax_amount').val();
                var discount_val = $('#discount').val();
                var paid_amount_val = $(this).val();

                //Tax amount Validation
                if (tax_amount == "" || tax_amount == 0) {
                    var tax = parseFloat(0);
                } else {
                    var tax = parseFloat(tax_amount);
                }

                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                } else {
                    var discount = parseInt(discount_val);
                }

                //Paid amount Validation
                if (paid_amount_val == "" || paid_amount_val == 0) {
                    var paid_amount = parseFloat(0);
                } else {
                    var paid_amount = parseFloat(paid_amount_val);
                }

                var amount = (total + tax);
                var total_amount = (amount - (amount * discount) / 100);
                var due_amount_val = (total_amount - paid_amount);

                //Due Amount Validation
                if (due_amount_val < 0) {
                    var due_amount = 0;
                    $('.err_paid_amount').text('Paid Amount must not be grater than '+total_amount);
                }
                else if (due_amount_val <= 0) {
                    var due_amount = 0;
                }
                else {
                    $('.err_paid_amount').text('');
                    var due_amount = due_amount_val;
                }
                $('#total_amount').val(total_amount.toFixed(2));
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
                    url: "{{ url('/admin/invoices/invoices/create') }}",
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
                        }
                        else if(response.status == false)
                        {
                            $('.err_product').text(response.message);
                        }
                        else {
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
                                            location.href = "{{ url('/admin/invoices/invoices') }}";
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
