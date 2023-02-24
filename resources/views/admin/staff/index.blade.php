@extends('layouts.admin_staff')

@section('title')

    Staffs

@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.staff')
@endsection

@section('content')

<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="statbox widget box box-shadow">

        <div class="col-lg-12 row">

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Staff</h5>
                    <h5 class="info-count">{{ ($staffcount['0'] + $staffcount['1']) }}</h5>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Active Staff</h5>
                    <h5 class="info-count">{{ $staffcount['1'] }}</h5>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="infobox-3">
                    <h5 class="info-heading">Total Inactive Staff</h5>
                    <h5 class="info-count">{{  $staffcount['0'] }}</h5>
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
                    <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Monthly Salary Paid -
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
                url: "{{url('/admin/staffs/get_monthly_salary')}}",
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
                            name: 'Amount',
                            data: response.amount
                        }],
                        yaxis: {
                            title: {
                                text: 'Total Paid'
                            }
                        },

                        xaxis: {
                            categories: response.month,
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
