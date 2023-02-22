@extends('layouts.admin_staff')

@section('title')

    Staffs

@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.staff')
@endsection

@section('content')

{{-- <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="statbox widget box box-shadow">

        <div class="col-lg-12 row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">No.of Purchase</h5>
                    <h5 class="info-count">{{ ($data['count']) }}</h5>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Purchase</h5>
                    <h5 class="info-count">{{ number_format($data['pur_total'],2,'.','') }}</h5>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                <div class="infobox-3">
                    <h5 class="info-heading">No.of Suppliers</h5>
                    <h5 class="info-count">{{  $data['supplier'] }}</h5>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Inventory Qty</h5>
                    <h5 class="info-count">{{ $data['inventory']  }}</h5>
                </div>
            </div>

        </div>
    </div>
</div> --}}

<div id="chartDonut" class="col-xl-12 col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Monthly Purchase Count -
                        {{ date('Y') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div id="chartPurchase" class=""></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        chartPurchase();

        function chartPurchase()
        {
            $.ajax({
                type: "GET",
                url: "{{url('/admin/inventory/get_purchase')}}",
                dataType: "JSON",
                success: function (response) {

                    var sLineArea = {
                        chart: {
                            height: 450,
                            type: 'area',
                            toolbar: {
                            show: false,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        series: [{
                            name: 'Count',
                            data: response.data.count
                        }],
                        yaxis: {
                            title: {
                                text: 'No. of Purchases'
                            }
                        },

                        xaxis: {
                            categories: response.data.month,
                        },

                    }

                    var chart = new ApexCharts(
                        document.querySelector("#chartPurchase"),
                        sLineArea
                    );

                    chart.render();
                }
            });
        }
    });
</script>

@endsection
