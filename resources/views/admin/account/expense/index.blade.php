@extends('layouts.admin_staff')

@section('title')
    Accounts - Expense
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.accounts')
@endsection

@section('content')
    @if (count($expense))
        <div class="col-lg-12 col-12  layout-spacing">
            <a href="{{ url('admin/accounts/expense/create') }}" class="btn btn-theme float-right text-uppercase">
                <i class="fa fa-plus"></i> Create New Expense
            </a>
        </div>

        <div class="col-lg-12 col-12  layout-spacing">
            <form action="">
                <div class="row">
                    <div class="col-lg-6 col-12 form-group">
                        <label for="">Year</label>
                        <select name="year" class="form-control disabled-results year">
                            <option value=""></option>
                            @foreach ($years as $item)
                                <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-12 form-group">
                        <label for="">Month</label>
                        <select name="month" class="form-control disabled-results month">
                            <option value=""></option>
                            @for ($i = 1; $i <=12; $i++)
                                <option value="{{$i}}">{{date('F', strtotime('2023-'.$i))}}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-lg-12 col-12 form-group">
                        <button type="button" class="btn btn-primary float-right ml-5 btn_filter" style="width: 150px">Filter</button>
                        <button type="button" class="btn btn-dark float-right btn_reset" style="width: 150px">Reset</button>
                    </div>

                </div>
            </form>
        </div>


        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                            <h3 class="font-weight-bold pt-2 pb-2 text-uppercase">Expenses</h3>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area br-6 m-2">
                    <table id="data_table" class="table table-striped" style="width:100%">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Year - Month</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th class="no-content">Actions</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-12  layout-spacing">
            <button id="btn_export" class="btn btn-dark float-right text-uppercase">
                <i class="fa fa-download"></i> Export Expenses
            </button>
        </div>
    @else
        <div class="col-lg-12 col-12 "
            style="height: calc(100vh - 40vh);  align-items: center; display: flex; justify-content: center;">
            <a href="{{ url('admin/accounts/expense/create') }}"
                class="btn btn-theme btn-lg text-uppercase font-weight-bold" style="width: 300px;"><i
                    class="fa fa-plus"></i> Create New Expense</a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table;

            loadDatas();

            function loadDatas()
            {
                table =  $('#data_table').DataTable({
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
                        url: "{!! url('/admin/accounts/get_expense') !!}",
                        data: function (d) {
                                d.year = $('.year').val(),
                                d.month = $('.month').val()
                            }
                        },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'year_month',
                            name: 'year_month',
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                        },
                        {
                            data: 'paid_date',
                            name: 'paid_date',
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

            $('.btn_filter').click(function (e) {
                e.preventDefault();

                //reload the table
                table.clear();
                table.ajax.reload();
                table.draw();
            });

            $('.btn_reset').click(function (e) {
                e.preventDefault();

                $('.year').val('').change();
                $('.month').val('').change();

                //reload the table
                table.clear();
                table.ajax.reload();
                table.draw();
            });

            $('#btn_export').click(function(e) {
                e.preventDefault();
                var year = $('.year').val();
                var month = $('.month').val();

                var data = {
                    'year': year,
                    'month': month
                }

                $.ajax({
                    xhrFields: {
                        responseType: 'blob',
                    },
                    type: "POST",
                    url: "{{ url('/admin/accounts/expense/export') }}",
                    data: data,
                    success: function(data) {
                        var name = Date.now();
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `accounts_` + name + `.xlsx`;
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
                content: 'Do you want to Delete the Selected Expense?',
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
                                url: "{{ url('/admin/accounts/expense/delete') }}",
                                data: data,
                                success: function(response) {
                                    location.href = "{{ url('/admin/accounts/expense') }}";
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
