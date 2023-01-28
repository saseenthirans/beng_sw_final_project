@extends('layouts.admin_staff')

@section('title')
    Inventory - Purchases
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.inventory')
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/inventory/purchases') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area">
            <form method="POST" id="submitForm" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 col-12 mt-5 ">
                    <div class="row">
                        <input type="hidden" name="pur_id" value="{{$purchase->id}}">
                        <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="paymethod_div">
                            <label for="exampleFormControlInput2">Payment Method<span class="text-danger">*</span></label>
                            <select name="pay_method" class="form-control">
                                <option value=""></option>
                                @foreach ($paymethod as $item)
                                    <option value="{{ $item->id }}">{{ $item->method }}</option>
                                @endforeach
                            </select>

                            <span class="text-danger font-weight-bold error_pay_method"></span>
                        </div>

                        <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="paid_date_div">
                            <label for="exampleFormControlInput2">Paid Date<span class="text-danger">*</span></label>
                            <input type="date" name="paid_date" id="paid_date" max="{{ date('Y-m-d') }}"
                                class="form-control">

                            <span class="text-danger font-weight-bold error_paid_date"></span>
                        </div>

                        <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="paid_amount_div">
                            <label for="exampleFormControlInput2">Paid Amount<span class="text-danger">*</span></label>
                            <input type="text" name="paid_amount" id="paid_amount" value="0"
                                class="form-control price">

                            <span class="text-danger font-weight-bold error_paid_amount"></span>
                        </div>

                        <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 text-right" id="due_amount_labl">
                            <label for="exampleFormControlInput2"
                                class="font-weight-bold text-black text-right text-uppercase">Purchase
                                Amount</label>
                        </div>

                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" id="due_amount_div">
                            <input type="text" name="purchase_amount" id="purchase_amount" value="{{ number_format($purchase->pur_amount,2,'.','')}}" readonly
                                class="form-control price text-right font-weight-bold text-black">

                            <span class="text-danger font-weight-bold error_purchase_amount"></span>
                        </div>

                        <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 text-right" id="due_amount_labl">
                            <label for="exampleFormControlInput2"
                                class="font-weight-bold text-black text-right text-uppercase">Discount
                                Amount</label>
                        </div>

                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" id="due_amount_div">
                            <input type="text" name="discount_amount" id="discount_amount" value="{{number_format($purchase->discount,2,'.','')}}" readonly
                                class="form-control price text-right font-weight-bold text-black">

                            <span class="text-danger font-weight-bold error_discount_amount"></span>
                        </div>

                        @php
                            $pur_amount = $purchase->pur_amount;
                            $discount = $purchase->discount;
                            $paid_amount = $purchase->purPayments->sum('amount');

                            $due_amount = ($pur_amount - $discount -$paid_amount);
                        @endphp

                        <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 text-right" id="due_amount_labl">
                            <label for="exampleFormControlInput2"
                                class="font-weight-bold text-black text-right text-uppercase">Paid
                                Amount</label>
                        </div>

                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" id="due_amount_div">
                            <input type="text" name="pur_paid_amount" id="pur_paid_amount" value="{{number_format(($paid_amount),2,'.','')}}" readonly
                                class="form-control price text-right font-weight-bold text-black">

                            <span class="text-danger font-weight-bold error_pur_paid_amount"></span>
                        </div>

                        <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 text-right" id="due_amount_labl">
                            <label for="exampleFormControlInput2"
                                class="font-weight-bold text-black text-right text-uppercase">Due
                                Amount</label>
                        </div>

                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" id="due_amount_div">
                            <input type="text" name="due_amount" id="due_amount" value="{{number_format(($due_amount),2,'.','')}}" readonly
                                class="form-control price text-right font-weight-bold text-danger">

                            <span class="text-danger font-weight-bold error_due_amount"></span>
                        </div>

                        @if ($due_amount > 0)
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
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                        <h3 class="font-weight-bold pt-2 pb-2 text-uppercase">Payments Information</h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area br-6 m-2">
                <table id="data_table" class="table table-striped" style="width:100%">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Paid Method</th>
                            <th>Paid Amount</th>
                            <th>Purchased Date</th>
                            <th></th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $(function() {
                $('#data_table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [10, 20, 50],
                    "pageLength": 10,

                    processing: true,
                    serverSide: true,
                    ajax: '{!! url('/admin/inventory/purchases/get_payments/' . $purchase->id) !!}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'paymethod',
                            name: 'paymethod'
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'paid_date',
                            name: 'paid_date',
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });

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
                    url: "{{ url('/admin/inventory/purchases/store_payments') }}",
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
                                            location.reload();
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

            function clearFormError() {
                $('.error_invoice_number').text('');
                $('.error_supplier').text('');
                $('.error_purchased_date').text('');
                $('.error_pay_method').text('');
                $('.error_paid_date').text('');
                $('.error_paid_amount').text('');
            }

            $('#paid_amount').keyup(function(e) {
                e.preventDefault();


                var paid_val = $(this).val();
                var paid_amount = '{{$due_amount}}';
                //Discount Validation

                var due_amount = (paid_amount - paid_val);

                if (due_amount >= 0) {
                    due_amount = due_amount;
                    $('.error_paid_amount').text('');
                    $('#submit_button').css('display', 'block');
                } else {
                    $('.error_paid_amount').text('Enter the valid Due Amount');
                    due_amount = parseFloat(0);
                    $('#submit_button').css('display', 'none');
                }

                $('#due_amount').val(due_amount.toFixed(2));

            });

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

<script>
    function deleteConfirmation(id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.confirm({
            theme: 'modern',
            columnClass: 'col-md-6 col-md-offset-4',
            icon: 'fa fa-info-circle text-danger',
            title: 'Are you Sure!',
            content: 'Do you want to Delete the Selected Payment?',
            type: 'red',
            autoClose: 'cancel|10000',
            buttons: {
                confirm: {
                    text: 'Yes',
                    btnClass: 'btn-150',
                    action: function() {
                        var data = {
                            "_token": $('input[name=_token]').val(),
                            "id": id,
                        }
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/admin/inventory/purchases/delete_payment') }}",
                            data: data,
                            success: function(response) {
                                location.reload();
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
    }
</script>
@endsection
