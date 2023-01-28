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
                        <h3 class="p-4 font-weight-bold text-uppercase">Update Purchases </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">
                            <input type="hidden" name="id" value="{{$purchase->id}}" id="">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Invoice Number<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="invoice_number" class="form-control"
                                        value="{{ $purchase->invoice }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_invoice_number"></span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Supplier<span class="text-danger">*</span></label>
                                    <select name="supplier" class="form-control disabled-results">
                                        <option value=""></option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $purchase->supplier_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
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
                                        value="{{ $purchase->pur_date }}" max="{{ date('Y-m-d') }}"
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
                                            <table class="table table-bordered table-striped mb-4">
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
                                                                <span class="text-danger error_product"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control qty"
                                                                    id="qty">
                                                                <span class="text-danger error_qty"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control price"
                                                                    id="price">

                                                                <span class="text-danger error_price"></span>
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

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped mb-4">

                                                <tbody id="input_field_table">

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
                                            <input type="text" readonly name="sub_total"
                                                value="{{ $purchase->pur_amount }}" id="sub_total"
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
                                                class="form-control discount price text-right text-black"
                                                value="{{ $purchase->discount }}" id="exampleFormControlInput2">
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
                                            <input type="text" readonly name="pur_total"
                                                value="{{ number_format($purchase->pur_amount - $purchase->discount, 2, '.', '') }}"
                                                id="pur_total"
                                                class="form-control pur_total text-right font-weight-bold text-black"
                                                value="0" id="exampleFormControlInput2">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mt-5 mb-5" id="submit_button">
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

            loadPurchaseItems();

            function loadPurchaseItems() {
                var id = '{{ $purchase->id }}';

                var data = {
                    "id": id
                }
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/inventory/purchases/get_items') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        $('#input_field_table').html('');

                        $.each(response.data, function(key, item) {
                            $('#input_field_table').append('<tr id="' + item.id + '">\
                                    <td>' + item.product_name + ' </td>\
                                    <td>' + item.qty + ' x ' + item.price_ + '</td>\
                                    <td>' + item.total_ + '</td>\
                                    <td><button type="button" class="btn btn-danger remove_button" id="' + item.id + '"><i class="fa fa-trash"></i></button></td>\
                                </tr>');

                            sub_total = (sub_total + item.total);
                        });

                        var discount_val = $('#discount').val();
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
                    }
                });
            }

            $('#add_button').click(function(e) {
                e.preventDefault();

                i++;
                var product = $('#product').val();
                var qty = $('#qty').val();
                var price = $('#price').val();
                var id = '{{ $purchase->id }}';

                var data = {
                    'product': product,
                    'qty': qty,
                    'price': price,
                    'id': id
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
                                    $('.error_' + key).text(item);
                                }
                            });
                        } else {
                            sub_total = 0;
                            clearInput();

                            loadPurchaseItems();

                        }
                    }
                });
            });

            $(document).on('click', '.remove_button', function(e) {
                e.preventDefault();

                var id = $(this).attr("id");
                var data = {
                    'id': id
                }

                $.confirm({
                    theme: 'modern',
                    columnClass: 'col-md-6 col-md-offset-4',
                    icon: 'fa fa-info-circle text-danger',
                    title: 'Are you Sure!',
                    content: 'Do you want to Delete the Selected Items?',
                    type: 'red',
                    autoClose: 'cancel|10000',
                    buttons: {
                        confirm: {
                            text: 'Yes',
                            btnClass: 'btn-150',
                            action: function() {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ url('/admin/inventory/purchases/delete_items') }}",
                                    data: data,
                                    dataType: "JSON",
                                    success: function(response) {
                                        sub_total = 0;
                                        loadPurchaseItems();
                                    }
                                });
                            }
                        },

                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-150-danger',
                            action: function() {

                            }
                        },
                    }
                });


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
                $('.error_product').text('');
                $('.error_qty').text('');
                $('.error_price').text('');
            }

            function clearFormError() {
                $('.error_invoice_number').text('');
                $('.error_supplier').text('');
                $('.error_purchased_date').text('');
                $('.error_pay_method').text('');
                $('.error_paid_date').text('');
                $('.error_paid_amount').text('');
            }

            function clearInput() {
                $('#product').val('').change();
                $('#qty').val('');
                $('#price').val('');
            }

            $('#submitForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#submitForm')[0]);

                $.ajax({
                    type: "POST",
                    beforeSend: function() {
                        $('#submit_button').css('display', 'none');
                        $('#disable_button').css('display', 'block');
                    },
                    url: "{{ url('/admin/inventory/purchases/update') }}",
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
                                    $('.error_' + key).text(item);
                                }
                            });
                        } else {
                            $.confirm({
                                theme: 'modern',
                                columnClass: 'col-xl-6 col-lg-6 col-md-6 col-12 col-md-offset-4',
                                title: 'Success! ',
                                content: response.message,
                                type: 'green',
                                buttons: {
                                    confirm: {
                                        text: 'OK',
                                        btnClass: 'btn-150',
                                        action: function() {
                                            location.href =
                                                "{{ url('/admin/inventory/purchases') }}";
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
