@extends('layouts.admin_staff')

@section('title')

    Invoice

@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.invoice')
@endsection

@section('content')

<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="statbox widget box box-shadow">

        <div class="col-lg-12 row">

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">No.of Invoice</h5>
                    <h5 class="info-count">{{ ($data['0']['count'] + $data['1']['count']) }}</h5>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">No.of Full Paid Invoice</h5>
                    <h5 class="info-count">{{  $data['1']['count'] }}</h5>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">No.of Due Invoice</h5>
                    <h5 class="info-count">{{  $data['0']['count'] }}</h5>
                </div>
            </div>

            @php
                $total = ($data['0']['total'] + $data['1']['total']);
                $paid = ($data['0']['paid'] + $data['1']['paid']);
                $due = $total - $paid;
            @endphp

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Invoice Amount</h5>
                    <h5 class="info-count">{{ number_format($total,2,'.','') }}</h5>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Paid Amount</h5>
                    <h5 class="info-count">{{  number_format($paid,2,'.','') }}</h5>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Due Amount</h5>
                    <h5 class="info-count">{{  number_format($due,2,'.','') }}</h5>
                </div>
            </div>



        </div>
    </div>
</div>

<div id="chartDonut" class="col-xl-12 col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Monthly Invoice Count -
                        {{ date('Y') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div id="chartInvoice" class=""></div>
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
                url: "{{url('/admin/invoices/get_invoice_count')}}",
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
                                text: 'No. of Invoice'
                            }
                        },

                        xaxis: {
                            categories: response.data.month,
                        },

                    }

                    var chart = new ApexCharts(
                        document.querySelector("#chartInvoice"),
                        sLineArea
                    );

                    chart.render();
                }
            });
        }
    });
</script>

@endsection
