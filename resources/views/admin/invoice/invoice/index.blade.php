@extends('layouts.admin_staff')

@section('title')
    Invoice - Invoice
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.invoice')
@endsection

@section('content')
    @if (count($invoices))
        <div class="col-lg-12 col-12  layout-spacing">
            <a href="{{ url('admin/invoices/invoices/create') }}" class="btn btn-theme float-right text-uppercase">
                <i class="fa fa-plus"></i> Create New Invoice
            </a>
        </div>

        <div class="col-lg-12 col-12  layout-spacing">
            <form action="">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                        <label for="">Customer</label>
                        <select name="customer" class="form-control disabled-results customer">
                            <option value=""></option>
                            @foreach ($customers as $item)
                                <option class="ml-4" value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                        <label for="">Start Date</label>
                        <input type="date" name="start_date" class="form-control start_date" max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                        <label for="">End Date</label>
                        <input type="date" name="end_date" class="form-control end_date" max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-lg-12 col-12 form-group">
                        <button type="button" class="btn btn-primary float-right ml-5 btn_filter"
                            style="width: 150px">Filter</button>
                        <button type="button" class="btn btn-dark float-right btn_reset"
                            style="width: 150px">Reset</button>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                            <h3 class="font-weight-bold pt-2 pb-2 text-uppercase">Invoice</h3>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area br-6 m-2">
                    <table id="data_table" class="table table-striped" style="width:100%">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice Id</th>
                                <th>Inv. Date</th>
                                <th>Customer</th>
                                <th>Created By</th>
                                <th>Sub Total</th>
                                <th>Discount (%)</th>
                                <th>Discount Amount</th>
                                <th>Final Amount</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                                <th class="no-content">Actions</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-12  layout-spacing">
            <button id="btn_export" class="btn btn-dark float-right text-uppercase">
                <i class="fa fa-download"></i> Export Invoice
            </button>
        </div>
    @else
        <div class="col-lg-12 col-12 "
            style="height: calc(100vh - 40vh);  align-items: center; display: flex; justify-content: center;">
            <a href="{{ url('admin/invoices/invoices/create') }}"
                class="btn btn-theme btn-lg text-uppercase font-weight-bold" style="width: 300px;"><i
                    class="fa fa-plus"></i> Create New Invoice</a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table;

            loadData();

            function loadData() {
                table = $('#data_table').DataTable({
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
                    ajax: {
                        url: "{!! url('/admin/invoices/get_invoices') !!}",
                        data: function(d) {
                            d.customer = $('.customer').val(),
                                d.start_date = $('.start_date').val(),
                                d.end_date = $('.end_date').val()
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'ref_no',
                            name: 'ref_no'
                        },
                        {
                            data: 'invoice_date',
                            name: 'invoice_date',
                            searchable: false
                        },
                        {
                            data: 'customer',
                            name: 'customer',
                            searchable: false
                        },
                        {
                            data: 'created_by',
                            name: 'created_by',
                            searchable: false
                        },
                        {
                            data: 'sub_total',
                            name: 'sub_total',
                            searchable: false
                        },
                        {
                            data: 'discount',
                            name: 'discount',
                            searchable: false
                        },
                        {
                            data: 'disc_amount',
                            name: 'disc_amount',
                            searchable: false
                        },
                        {
                            data: 'total',
                            name: 'total',
                            searchable: false
                        },
                        {
                            data: 'due_amount',
                            name: 'due_amount',
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            searchable: false
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            }

            $('.btn_filter').click(function(e) {
                e.preventDefault();

                //reload the table
                table.clear();
                table.ajax.reload();
                table.draw();
            });

            $('.btn_reset').click(function(e) {
                e.preventDefault();

                $('.customer').val('').change(),
                    $('.start_date').val('');
                $('.end_date').val('');

                //reload the table
                table.clear();
                table.ajax.reload();
                table.draw();
            });

            $('.start_date').change(function(e) {
                e.preventDefault();
                $('.end_date').attr('min', $(this).val());
                $('.end_date').val($(this).val());
            });

            $('#btn_export').click(function(e) {
                e.preventDefault();
                var customer = $('.customer').val();
                var start_date = $('.start_date').val();
                var end_date = $('.end_date').val();

                var data = {
                    'customer': customer,
                    'start_date': start_date,
                    'end_date': end_date
                }

                $.ajax({
                    xhrFields: {
                        responseType: 'blob',
                    },
                    type: "POST",
                    url: "{{ url('/admin/invoices/invoices/export') }}",
                    data: data,
                    success: function(data) {
                        var name = Date.now();
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `invoices_` + name + `.xlsx`;
                        link.click();
                    },
                });
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
                content: 'Do you want to Delete the Selected Invoice? If you delete you will lost the Related Invoice Data and Inventory will update',
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
                                url: "{{ url('/admin/invoices/invoices/delete') }}",
                                data: data,
                                success: function(response) {
                                    location.href = "{{ url('/admin/invoices/invoices') }}";
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

    @if (session('mail_success'))
        <script>
            $(document).ready(function() {
                $.confirm({
                    theme: 'modern',
                    columnClass: 'col-md-6 col-12 col-md-offset-4',
                    title: 'Success! ',
                    content: '{{ session('mail_success') }}',
                    type: 'green',
                    buttons: {
                        confirm: {
                            text: 'OK',
                            btnClass: 'btn-150',
                            action: function() {

                            }
                        },
                    }
                });
            });
        </script>
    @endif
@endsection
