<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Staff Salary Export</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="6" style="text-transform: uppercase; font-size: 20px; text-align: center">
                    RK MOBILES
                </th>
            </tr>
            <tr>
                <th colspan="6" style="text-transform: uppercase; font-size: 16px; text-align: left">
                    Staff Salary Summery Report
                </th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="6">
                    @if ($staff != '')
                        Staff Name : {{$staff}}
                    @endif
                </th>
            </tr>
            <tr>
                <th colspan="3">
                    @if (isset($request->start_date) && !empty($request->start_date))
                        From : {{date('M, d Y', strtotime($request->start_date))}}
                    @endif
                </th>
                <th colspan="3">
                    @if (isset($request->end_date) && !empty($request->end_date))
                        To : {{date('M, d Y', strtotime($request->end_date))}}
                    @endif
                </th>

            </tr>

            <tr></tr>
            <tr>
                <th colspan="6" style="text-transform: uppercase; text-align: right">
                    Generated By : {{Auth::user()->name}}
                </th>
            </tr>
            <tr>
                <th colspan="6" style="text-transform: uppercase; text-align: right">
                    Generated At : {{date('M, d Y h:i A')}}
                </th>
            </tr>

            <tr></tr>

            <tr>
                <th style="font-weight: 600; text-align: center">#</th>
                <th style="font-weight: 600; text-align: center">Staff Name</th>
                <th style="font-weight: 600; text-align: center">Basic Salary</th>
                <th style="font-weight: 600; text-align: center">Year Month</th>
                <th style="font-weight: 600; text-align: center">Updated Date</th>
                <th style="font-weight: 600; text-align: center">Paid Salary</th>
            </tr>
        </thead>
        <tbody>
            @if (count($salary))
                @php
                    $i = 0;
                    $paidamount = 0;
                @endphp
                @foreach ($salary as $item)
                    @php
                        $i++;
                        $year_month = $item->paid_year.'-'.$item->paid_month;
                    @endphp

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$item->staff->name}}</td>
                        <td>{{$item->staff->basicSalary->salary}}</td>
                        <td>{{date('Y F', strtotime($year_month))}}</td>
                        <td>{{date('Y-m-d', strtotime($item->updated_at))}}</td>
                        <td style="text-align: right">{{number_format($item->paid_amount,2)}}</td>
                    </tr>
                    @php
                        $paidamount = (($paidamount + $item->paid_amount));
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5"></td>
                    <td style="font-weight: 600;text-align: right">{{number_format($paidamount, 2)}}</td>
                </tr>
            @else
                <tr>
                    <th colspan="6" style="text-transform: uppercase; font-size: 14px; text-align: center">
                        No Data Found!
                    </th>
                </tr>
            @endif

        </tbody>
    </table>
</body>
</html>
