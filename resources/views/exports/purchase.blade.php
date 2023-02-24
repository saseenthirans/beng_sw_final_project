<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Export</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="10" style="text-transform: uppercase; font-size: 20px; text-align: center">
                    RK MOBILES
                </th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="4">
                    @if ($supplier != '')
                        Supplier : {{$supplier}}
                    @endif
                </th>
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
                <th colspan="10" style="text-transform: uppercase; text-align: right">
                    Generated By : {{Auth::user()->name}}
                </th>
            </tr>
            <tr>
                <th colspan="10" style="text-transform: uppercase; text-align: right">
                    Generated At : {{date('M, d Y h:i A')}}
                </th>
            </tr>

            <tr></tr>

            <tr>
                <th style="font-weight: 600; text-align: center">#</th>
                <th style="font-weight: 600; text-align: center">Invoice No</th>
                <th style="font-weight: 600; text-align: center">Supplier Name</th>
                <th style="font-weight: 600; text-align: center">Purchased Date</th>
                <th style="font-weight: 600; text-align: center">Purchased Amount</th>
                <th style="font-weight: 600; text-align: center">Discount amount</th>
                <th style="font-weight: 600; text-align: center">Final Amount</th>
                <th style="font-weight: 600; text-align: center">Paid Amount</th>
                <th style="font-weight: 600; text-align: center">Due Amount</th>
                <th style="font-weight: 600; text-align: center">Purchased Status</th>
            </tr>
        </thead>
        <tbody>
            @if (count($purchases))
                @php
                    $i = 0;
                    $pur_amount = 0;
                    $discount = 0;
                    $amount = 0;
                    $paidamount = 0;
                    $due_amount = 0;
                @endphp
                @foreach ($purchases as $item)
                    @php
                        $i++;
                        $paid_amount = 0;
                        if (count($item->purPayments)) {
                            $paid_amount = $item->purPayments->sum('amount');
                        }
                    @endphp

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$item->invoice}}</td>
                        <td>{{$item->supplier->name}}</td>
                        <td>{{$item->pur_date}}</td>
                        <td style="text-align: right">{{number_format($item->pur_amount,2)}}</td>
                        <td style="text-align: right">{{number_format($item->discount,2)}}</td>
                        <td style="text-align: right">{{number_format(($item->pur_amount - $item->discount),2)}}</td>
                        <td style="text-align: right">{{number_format($paid_amount, 2)}}</td>
                        <td style="text-align: right">{{number_format(($item->pur_amount - $item->discount - $paid_amount),2)}}</td>
                        <td style="text-align: center">{{$item->status == '0' ? 'Unsettled' : 'Settled'}}</td>
                    </tr>
                    @php
                        $pur_amount = $pur_amount + $item->pur_amount;
                        $discount = (($discount + $item->discount));
                        $amount = ($amount + ($item->pur_amount - $item->discount));
                        $paidamount = (($paidamount + $paid_amount));
                        $due_amount = ($due_amount + ($item->pur_amount - $item->discount - $paid_amount));
                    @endphp
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td style="font-weight: 600;text-align: right">{{number_format($pur_amount, 2)}}</td>
                    <td style="font-weight: 600;text-align: right">{{number_format($discount, 2)}}</td>
                    <td style="font-weight: 600;text-align: right">{{number_format($amount, 2)}}</td>
                    <td style="font-weight: 600;text-align: right">{{number_format($paidamount, 2)}}</td>
                    <td style="font-weight: 600;text-align: center">{{number_format($due_amount, 2)}}</td>
                </tr>
            @else
                <tr>
                    <th colspan="10" style="text-transform: uppercase; font-size: 14px; text-align: center">
                        No Data Found!
                    </th>
                </tr>
            @endif

        </tbody>
    </table>
</body>
</html>
