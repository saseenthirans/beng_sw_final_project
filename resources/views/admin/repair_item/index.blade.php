@extends('layouts.admin_staff')

@section('title')
    Repair Items
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.repair_item')
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Repair Items</h4>
                        <span class="text-primary font-weight-bolder text-center text-uppercase">{{ '1 '.date('F, Y').' - '.date('t F, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 row">

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <div class="infobox-3">
                        <h5 class="info-heading">Total Repairs</h5>
                        <h5 class="info-count">{{ $count['pending'] + $count['completed'] }}</h5>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                    <div class="infobox-3">
                        <h5 class="info-heading">Pending Repairs</h5>
                        <h5 class="info-count">{{ $count['pending'] }}</h5>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="infobox-3">
                        <h5 class="info-heading">Completed Repairs</h5>
                        <h5 class="info-count">{{ $count['completed'] }}</h5>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <div class="infobox-3">
                        <h5 class="info-heading">Total Amount (RS)</h5>
                        <h5 class="info-count">{{ number_format($amount['total'],2,'.','') }}</h5>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                    <div class="infobox-3">
                        <h5 class="info-heading">Paid Amount (RS)</h5>
                        <h5 class="info-count">{{ number_format($amount['paid'],2,'.','') }}</h5>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="infobox-3">
                        <h5 class="info-heading">Due Amount (RS)</h5>
                        <h5 class="info-count">{{ number_format(($amount['total'] - $amount['paid']),2,'.','') }}</h5>
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
                        <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Monthly Repair Income
                            -
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
        $(document).ready(function() {

            chartPurchase();

            function chartPurchase() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/admin/repair_items/get_monthly_income') }}",
                    dataType: "JSON",
                    success: function(response) {
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
                            series: [
                                {
                                    name: 'Paid',
                                    data: response.data.paid
                                },
                                {
                                    name: 'Due',
                                    data: response.data.pending
                                }
                            ],
                            yaxis: {
                                title: {
                                    text: 'Total Income'
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
