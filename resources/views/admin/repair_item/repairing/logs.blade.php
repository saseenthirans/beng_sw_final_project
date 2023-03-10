@extends('layouts.admin_staff')

@section('title')
Repair Item - Repairing
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.repair_item')
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
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
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                        <h3 class="font-weight-bold pt-2 pb-2 text-uppercase">Access Information</h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area br-6 m-2">
                <table id="data_table" class="table table-striped" style="width:100%">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Update Person Name</th>
                            <th>Wrok Did</th>
                            <th>Updated Date</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

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
                    ajax: '{!! url('/admin/repair_items/repairing/get_logs/'.$repairing->id) !!}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created',
                            name: 'created'
                        },
                        {
                            data: 'work',
                            name: 'work'
                        },
                        {
                            data: 'acc_date',
                            name: 'acc_date',
                            searchable: false
                        }
                    ]
                });
            });
        });
    </script>
@endsection
