@extends('layouts.admin_staff')

@section('title')

    Accounts

@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.accounts')
@endsection

@section('content')

<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="statbox widget box box-shadow">

        <div class="col-lg-12 row">

            @php
                $current_month = date('n',strtotime(date('Y-m-d')));
                $last_month_ = $current_month - 1;
            @endphp
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">Last Month Expense</h5>
                    <h5 class="info-heading">({{date('Y F', strtotime(date('Y').'-'.$last_month_))}})</h5>
                    <h5 class="info-count">{{ ($last_month_data) }}</h5>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                <div class="infobox-3">
                    <h5 class="info-heading">Current Month Expense</h5>
                    <h5 class="info-heading">({{date('Y F', strtotime(date('Y-m')))}})</h5>
                    <h5 class="info-count">{{ $current_month_data }}</h5>
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
                    <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Current and Last Month Expense -
                        {{ date('Y') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div id="chartPurchase" class=""></div>
        </div>
    </div>
</div>

<div id="chartDonut" class="col-xl-12 col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4 class="text-center font-weight-bold text-uppercase" style="font-size: 24px">Monthly Expenses -
                        {{ date('Y') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div id="chartMonthlyExpense" class=""></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        chartPurchase();
        chartExpense();

        function chartPurchase()
        {
            $.ajax({
                type: "GET",
                url: "{{url('/admin/accounts/get_expense_data')}}",
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
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
                            name: response.data[0].date,
                            data: response.data[0].amount
                        },
                        {
                            name: response.data[1].date,
                            data: response.data[1].amount
                        }
                    ],
                        yaxis: {
                            title: {
                                text: 'Current and Last Month Expense'
                            }
                        },

                        xaxis: {
                            categories: response.category_data,
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



        function chartExpense()
        {
            $.ajax({
                type: "GET",
                url: "{{url('/admin/accounts/get_monthly_expense')}}",
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
                            name: 'Paid Amount',
                            data: response.amount
                        }],
                        yaxis: {
                            title: {
                                text: 'Monthly Expenses'
                            }
                        },

                        xaxis: {
                            categories: response.month,
                        },

                    }

                    var chart = new ApexCharts(
                        document.querySelector("#chartMonthlyExpense"),
                        sLineArea
                    );

                    chart.render();
                }
            });
        }
    });
</script>

@endsection
