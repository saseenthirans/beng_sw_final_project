@extends('layouts.admin_staff')

@section('title')
    Inventory - Purchases
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.inventory')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/inventory/purchases') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Create New Purchases </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Invoice Number<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="invoice_number" class="form-control"
                                        value="{{ old('invoice_number') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_invoice_number"></span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Supplier<span class="text-danger">*</span></label>
                                    <select name="supplier" class="form-control disabled-results">
                                        <option value=""></option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold error_supplier"></span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Purchased Date<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="purchased_date" class="form-control"
                                        value="{{ old('purchased_date') }}" max="{{ date('Y-m-d') }}"
                                        id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_purchased_date"></span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Invoice DOC</label>
                                    <input type="file" name="invoice_doc" class="form-control-file"
                                        value="{{ old('invoice_doc') }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_invoice_doc"></span>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 border border-dashed border-primary">
                                <div class="row mt-3">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <h5 class="text-primary font-weight-bold">Purchased Items</h5
                                            class="text-primary font-weight-bold">
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped mb-4" id="input_field_table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40%">Product</th>
                                                        <th style="width: 25%">Qty</th>
                                                        <th style="width: 25%">Price</th>
                                                        <th style="width: 10%" class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <select id="product"
                                                                    class="form-control disabled-results">
                                                                    <option value=""></option>
                                                                    @foreach ($inventory as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->code . ' - ' . $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <br>
                                                                <span class="text-danger err_product"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control qty"
                                                                    id="qty">
                                                                <span class="text-danger err_qty"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control price"
                                                                    id="price">

                                                                <span class="text-danger err_price"></span>
                                                            </div>
                                                        </td>
                                                        <td class=" text-center">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="add_button"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
                                                class="font-weight-bold text-black text-right text-uppercase">Discount</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group mb-0">
                                            <input type="text" name="discount" id="discount"
                                                class="form-control discount price text-right text-black" value="0"
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
                                                class="font-weight-bold text-black text-right text-uppercase">Total</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group mb-0">
                                            <input type="text" readonly name="pur_total" id="pur_total"
                                                class="form-control pur_total text-right font-weight-bold text-black"
                                                value="0" id="exampleFormControlInput2">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4 border border-dashed border-primary">
                                <div class="row mt-3">
                                    <div class="form-group col-lg-6 col-12">
                                        <label for="formGroupExampleInput2">Not Paid / Paid</label>
                                        <div>
                                            <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                                <input type="checkbox" name="is_paid" onclick='handleClick(this);'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 col-12"></div>

                                    <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="paymethod_div"
                                        style="display: none">
                                        <label for="exampleFormControlInput2">Payment Method<span
                                                class="text-danger">*</span></label>
                                        <select name="paymethod" class="form-control">
                                            <option value=""></option>
                                            @foreach ($paymethod as $item)
                                                <option value="{{ $item->id }}">{{ $item->method }}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger font-weight-bold error_paymethod"></span>
                                    </div>

                                    <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="paid_date_div"
                                        style="display: none">
                                        <label for="exampleFormControlInput2">Paid Date<span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="paid_date" class="form-control">

                                        <span class="text-danger font-weight-bold error_paid_date"></span>
                                    </div>

                                    <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12"
                                        id="paid_amount_div" style="display: none">
                                        <label for="exampleFormControlInput2">Paid Amount<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="paid_amount" id="paid_amount" value="0"
                                            class="form-control price">

                                        <span class="text-danger font-weight-bold error_paid_amount"></span>
                                    </div>

                                    <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 text-right"
                                        id="due_amount_labl" style="display: none">
                                        <label for="exampleFormControlInput2"
                                            class="font-weight-bold text-black text-right text-uppercase">Due
                                            Amount</label>
                                    </div>

                                    <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"
                                        id="due_amount_div" style="display: none">
                                        <input type="text" name="due_amount" id="due_amount" value="0" readonly
                                            class="form-control price text-right font-weight-bold text-black">

                                        <span class="text-danger font-weight-bold error_due_amount"></span>
                                    </div>

                                </div>

                            </div>



                            <div class="col-lg-12 col-12 mt-5 mb-5" id="submit_button">
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
    <script type="text/javascript">
        function handleClick(val) {
            var element = document.getElementById('paymethod_div');
            var element1 = document.getElementById('paid_date_div');
            var element2 = document.getElementById('paid_amount_div');
            var element3 = document.getElementById('due_amount_labl');
            var element4 = document.getElementById('due_amount_div');

            if (val.checked == true) {
                element.style.display = 'block';
                element1.style.display = 'block';
                element2.style.display = 'block';
                element3.style.display = 'block';
                element4.style.display = 'block';
            } else {
                element.style.display = 'none';
                element1.style.display = 'none';
                element2.style.display = 'none';
                element3.style.display = 'none';
                element4.style.display = 'none';
            }

        }
    </script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var i = 1;
            let sub_total = 0;

            $('#add_button').click(function(e) {
                e.preventDefault();

                i++;
                var product = $('#product').val();
                var qty = $('#qty').val();
                var price = $('#price').val();

                var data = {
                    'product': product,
                    'qty': qty,
                    'price': price
                }

                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/inventory/purchases/product_validation') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        clearError();
                        if (response.status == false) {
                            $.each(response.errors, function(key, item) {
                                if (key) {
                                    $('.err_' + key).text(item);
                                }
                            });
                        } else {
                            clearInput();

                            $('#input_field_table').append('<tr id="row_' + i + '">\
                                        <td>' + response.data.product_name +
                                ' <input type="hidden" name="product_id[]"  value="' +
                                response.data.product_id + '"> </td>\
                                        <td>' + response.data.qty + ' x ' + response.data.price_ +
                                ' <input type="hidden" name="qty[]"  value="' + response
                                .data
                                .qty + '"></td>\
                                        <td>' + response.data.total_ + '<input type="hidden" id="pur_amount"  value="' +
                                response.data.total +
                                '"> <input type="hidden" name="price[]"  value="' + response
                                .data.price + '"></td>\
                                        <td><button type="button" class="btn btn-danger remove_button" id="' + i + '"><i class="fa fa-trash"></i></button></td>\
                                    </tr>');

                            var discount_val = $('#discount').val();
                            var paid_val = $('#paid_amount').val();

                            //Discount Validation
                            if (discount_val == "" || discount_val == 0) {
                                var discount = parseInt(0);
                            } else {
                                var discount = parseInt(discount_val);
                            }

                            sub_total = (sub_total + response.data.total);

                            var pur_total = (sub_total - discount);

                            var due_amount = (pur_total - paid_val);

                            if (sub_total > 0) {
                                sub_total = sub_total;
                                pur_total = pur_total;
                                due_amount = due_amount;
                            } else {
                                sub_total = parseFloat(0);
                                pur_total = parseFloat(0);
                                due_amount = parseFloat(0);
                                $('#discount').val(parseFloat(0));
                                $('#paid_amount').val(parseFloat(0));
                            }

                            if (due_amount >= 0) {
                                due_amount = due_amount;
                            } else {
                                // error_paid_amount
                                due_amount = parseFloat(0);
                            }

                            $('#sub_total').val(sub_total.toFixed(2));
                            $('#pur_total').val(pur_total.toFixed(2));
                            $('#due_amount').val(due_amount.toFixed(2));
                        }

                    }
                });
            });

            $(document).on('click', '.remove_button', function(e) {
                e.preventDefault();

                var button_id = $(this).attr("id");
                var val = $(this).closest('#row_' + button_id + '').find('#pur_amount').val();

                var discount_val = $('#discount').val();
                var paid_val = $('#paid_amount').val();

                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                } else {
                    var discount = parseInt(discount_val);
                }

                sub_total = (sub_total - val);

                var pur_total = (sub_total - discount);
                var due_amount = (pur_total - paid_val);

                if (sub_total > 0) {
                    sub_total = sub_total;
                    pur_total = pur_total;
                    due_amount = due_amount;
                } else {
                    sub_total = parseFloat(0);
                    pur_total = parseFloat(0);
                    due_amount = parseFloat(0);
                    $('#discount').val(parseFloat(0));
                    $('#paid_amount').val(parseFloat(0));
                }

                if (due_amount >= 0) {
                    due_amount = due_amount;
                } else {
                    // error_paid_amount
                    due_amount = parseFloat(0);
                }

                $('#sub_total').val(sub_total.toFixed(2));
                $('#pur_total').val(pur_total.toFixed(2));
                $('#due_amount').val(due_amount.toFixed(2));

                $('#row_' + button_id + '').remove();
            });

            $('#discount').keyup(function(e) {
                e.preventDefault();

                var discount_val = $(this).val();
                var paid_val = $('#paid_amount').val();

                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                } else {
                    var discount = parseInt(discount_val);
                }

                var pur_total = (sub_total - discount);
                var due_amount = (pur_total - paid_val);

                if (sub_total > 0) {
                    sub_total = sub_total;
                    pur_total = pur_total;
                    due_amount = due_amount;
                } else {
                    sub_total = parseFloat(0);
                    pur_total = parseFloat(0);
                    due_amount = parseFloat(0);
                    $('#discount').val(parseFloat(0));
                    $('#paid_amount').val(parseFloat(0));
                }

                if (due_amount >= 0) {
                    due_amount = due_amount;
                } else {
                    // error_paid_amount
                    due_amount = parseFloat(0);
                }

                $('#sub_total').val(sub_total.toFixed(2));
                $('#pur_total').val(pur_total.toFixed(2));
                $('#due_amount').val(due_amount.toFixed(2));
            });

            $('#paid_amount').keyup(function(e) {
                e.preventDefault();

                var discount_val = $('#discount').val();
                var paid_val = $(this).val();
                //Discount Validation
                if (discount_val == "" || discount_val == 0) {
                    var discount = parseInt(0);
                } else {
                    var discount = parseInt(discount_val);
                }

                var pur_total = (sub_total - discount);

                var due_amount = (pur_total - paid_val);

                if (sub_total > 0) {
                    sub_total = sub_total;
                    pur_total = pur_total;
                    due_amount = due_amount;
                } else {
                    sub_total = parseFloat(0);
                    pur_total = parseFloat(0);
                    due_amount = parseFloat(0);
                    $('#discount').val(parseFloat(0));
                    $('#paid_amount').val(parseFloat(0));
                }

                if (due_amount >= 0) {
                    due_amount = due_amount;
                    $('.error_paid_amount').text('');
                } else {
                    $('.error_paid_amount').text('Enter the valid Due Amount');
                    due_amount = parseFloat(0);
                }

                $('#sub_total').val(sub_total.toFixed(2));
                $('#pur_total').val(pur_total.toFixed(2));
                $('#due_amount').val(due_amount.toFixed(2));

            });

            function clearError() {
                $('.err_product').text('');
                $('.err_qty').text('');
                $('.err_price').text('');
            }

            function clearFormError() {
                $('.err_purchase_number').text('');
                $('.err_date').text('');
                $('.err_supplier').text('');
                $('.err_tax_amount').text('');
            }

            function clearInput() {
                $('#product').val('').change();
                $('#qty').val('');
                $('#price').val('');
            }

            $('#form_submit').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#form_submit')[0]);

                $.ajax({
                    type: "POST",
                    beforeSend: function() {
                        $('#submit_button').css('display', 'none');
                        $('#disable_button').css('display', 'block');
                    },
                    url: "{{ url('/purchases/create') }}",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        clearFormError();
                        $('#submit_button').css('display', 'block');
                        $('#disable_button').css('display', 'none');

                        if (response.status == false) {
                            $.each(response.errors, function(key, item) {
                                if (key) {
                                    $('.err_' + key).text(item);
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
                                                "{{ url('/purchases') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

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
