<!DOCTYPE html>
<html>
<head>
	<title>Purchase - {{$purchase->invoice}}</title>
</head>
<body>

    <div>
        <table border="0" width="100%">
            <tr>
                <td width="20%" style="font-size: 12px;font-weight: bold; font-family: sans-serif">Invoice No</td>
                <td width="30%" style="font-size: 12px; font-family: sans-serif"> : {{$purchase->invoice}}</td>
                <td width="20%" style="font-size: 12px;font-weight: bold; font-family: sans-serif">Supplier Id</td>
                <td width="30%" style="font-size: 12px; font-family: sans-serif"> : {{$purchase->supplier_id}}</td>
            </tr>

            <tr>
                <td width="20%" style="font-size: 12px;font-weight: bold; font-family: sans-serif">Date</td>
                <td width="30%" style="font-size: 12px; font-family: sans-serif"> : {{$purchase->pur_date}}</td>
                <td width="20%" style="font-size: 12px;font-weight: bold; font-family: sans-serif">Supplier Name</td>
                <td width="30%" style="font-size: 12px; font-family: sans-serif"> :  {{$purchase->supplier->name}}</td>
            </tr>

            <tr>
                <td width="20%" style="font-size: 12px;font-weight: bold; font-family: sans-serif"></td>
                <td width="30%" style="font-size: 12px; font-family: sans-serif"> </td>
                <td width="20%" style="font-size: 12px;font-weight: bold; font-family: sans-serif">Payment Status</td>
                <td width="30%" style="font-size: 12px; font-family: sans-serif"> :  {{$purchase->status == 1 ? 'Settled' : 'Unsetteled'}}</td>
            </tr>


        </table>
        <br>

        <h3 style="font-size: 18px;font-weight: bold; font-family: sans-serif">Purchased Details</h3>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
            <tr style="background-color: #a3a3a3; color:#fff">
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="5%">#</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="45%">Item</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="10%">Qty</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="15%">Price</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="15%">Amount</th>
            </tr>

            @if (count($purchase->purItems))
                @php
                    $i = 0;
                @endphp
                @foreach ($purchase->purItems as $item)
                    @php
                        $i++;
                    @endphp
                <tr>
                    <td style="border: 1px solid #a3a3a3; font-size:12px; padding:5px;text-align:center"> {{$i}}</td>
                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;"> {{$item->product->name}} </td>

                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:center">{{$item->qty}}</td>
                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right">{{$item->unit_price}}</td>
                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right">{{$item->amount}}</td>
                </tr>
               @endforeach

                <tr style="background-color:#a3a3a3; color:#fff">
                    <td colspan="4" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">Sub Total</td>
                    <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">{{ number_format(($purchase->pur_amount),2,'.','')}}</td>
                </tr>
                <tr style="background-color:#a3a3a3; color:#fff">
                    <td colspan="4" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">Discount Amount</td>
                    <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">{{number_format(($purchase->discount),2,'.','')}} </td>
                </tr>
                <tr style="background-color:#a3a3a3; color:#fff">
                    <td colspan="4" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">Gross Total</td>
                    <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">{{number_format(($purchase->pur_amount - $purchase->discount),2,'.','')}}</td>
                </tr>
            @else
                <tr>
                    <td colspan="5" style="border: 1px solid #a3a3a3; font-size:12px; padding:5px; font-weight:bold; text-align:center">Sorry! No Data Found ...</td>

                </tr>
            @endif
        </table>

        @if ($purchase->purPayments)
            <h3 style="font-size: 18px;font-weight: bold; font-family: sans-serif">Payment Details</h3>

            <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="background-color: #a3a3a3; color:#fff">
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="5%">#</th>
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="45%">Paid Method</th>
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="30%">Paid Date</th>
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px" width="20%">Paid Amount</th>
                </tr>

                @php
                    $j = 0;
                @endphp
                @foreach ($purchase->purPayments as $item)
                        @php
                            $j++;
                        @endphp
                    <tr>
                        <td style="border: 1px solid #a3a3a3; font-size:12px; padding:5px;text-align:center"> {{$j}}</td>
                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;"> {{$item->payMethod->method}} </td>

                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:center">{{date('Y-m-d', strtotime($item->paid_date))}}</td>
                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right">{{$item->amount}}</td>
                    </tr>
                   @endforeach

                    <tr style="background-color:#a3a3a3; color:#fff">
                        <td colspan="3" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">Total Paid</td>
                        <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">{{ number_format($purchase->purPayments->sum('amount'),2,'.','')}}</td>
                    </tr>

                    <tr style="background-color:#a3a3a3; color:#fff">
                        <td colspan="3" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">Due Amount</td>
                        <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right">{{number_format(($purchase->pur_amount - $purchase->discount - $purchase->purPayments->sum('amount')),2,'.','')}}</td>
                    </tr>
            </table>
        @endif

    </div>

</body>
</html>
