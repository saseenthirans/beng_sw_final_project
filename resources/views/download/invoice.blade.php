<!DOCTYPE html>
<html>
<head>
	<title>Invoice - {{$invoice->ref_no}}</title>
</head>
<body>

    <div>
        <table border="0" width="100%">
            <tr>
                <td width="100%" style="font-size: 22px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                    {{$company->name}}
                </td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 11px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                   Address : {{$company->address}}
                </td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 11px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                   Email Address : {{$company->email}}
                </td>
            </tr>

            <tr>
                <td width="100%" style="font-size: 11px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                   Contact : {{$company->contact}}
                </td>
            </tr>

        </table>
        <hr>
        <table border="0" width="100%" style="margin-top: 10px">
            <tr>
                <td width="100%" style="font-size: 20px;font-weight: bold; font-family: sans-serif; text-align: right; text-transform: uppercase; {{$invoice->status == 1 ? 'color:green' : 'color:red'}}">{{$invoice->status == 1 ? 'Settled' : 'Unsettled'}}</td>
            </tr>
        </table>

        <table border="0" width="100%" style="margin-top: 10px">
            <tr>
                <td width="100%" style="font-size: 16px;font-weight: bold; font-family: sans-serif;text-transform: uppercase">Invoice No #{{$invoice->ref_no}}</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 14px; font-family: sans-serif;text-transform: uppercase">Invoice Date : {{date('l, F, jS, Y', strtotime($invoice->invoice_date))}}</td>
            </tr>
        </table>

        <table border="0" width="100%" style="margin-top: 20px">
            <tr>
                <td width="100%" style="font-size: 14px;font-weight: bold; font-family: sans-serif;text-transform: uppercase">Invoice To</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 12px; font-family: sans-serif;text-transform: uppercase">{{$invoice->customers->name}}</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 12px; font-family: sans-serif">{{$invoice->customers->contact}}</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 12px; font-family: sans-serif;text-transform: lowercase">{{$invoice->customers->email}}</td>
            </tr>

        </table>

        <br>

        <h3 style="font-size: 18px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">Invoice Item Summery</h3>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
            <tr style="background-color: #a3a3a3; color:#fff">
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="5%">#</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="45%">Item</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="10%">Qty</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="15%">Price</th>
               <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="15%">Amount</th>
            </tr>

            @if (count($invoice->invoiceItems))
                @php
                    $i = 0;
                @endphp
                @foreach ($invoice->invoiceItems as $item)
                    @php
                        $i++;
                    @endphp
                <tr>
                    <td style="border: 1px solid #a3a3a3; font-size:12px; padding:5px;text-align:center;text-transform: uppercase"> {{$i}}</td>
                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-transform: uppercase"> {{$item->product->name}} </td>

                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:center;text-transform: uppercase">{{$item->qty}}</td>
                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right;text-transform: uppercase">{{$item->amount}}</td>
                    <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right;text-transform: uppercase">{{$item->total}}</td>
                </tr>
               @endforeach

                <tr style="background-color:#a3a3a3; color:#fff">
                    <td colspan="4" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">Sub Total</td>
                    <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">{{ number_format(($invoice->sub_total),2,'.','')}}</td>
                </tr>
                <tr style="background-color:#a3a3a3; color:#fff">
                    <td colspan="4" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">Discount Amount</td>
                    <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">{{number_format(($invoice->disc_amount),2,'.','')}} </td>
                </tr>
                <tr style="background-color:#a3a3a3; color:#fff">
                    <td colspan="4" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">Gross Total</td>
                    <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">{{number_format(($invoice->sub_total - $invoice->disc_amount),2,'.','')}}</td>
                </tr>
            @else
                <tr>
                    <td colspan="5" style="border: 1px solid #a3a3a3; font-size:12px; padding:5px; font-weight:bold; text-align:center;text-transform: uppercase">Sorry! No Data Found ...</td>

                </tr>
            @endif
        </table>

        @if (count($invoice->invoicePayment))
            <h3 style="font-size: 18px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">Payment Details</h3>

            <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="background-color: #a3a3a3; color:#fff">
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="5%">#</th>
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="45%">Paid Method</th>
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="30%">Paid Date</th>
                   <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase" width="20%">Paid Amount</th>
                </tr>

                @php
                    $j = 0;
                @endphp
                @foreach ($invoice->invoicePayment as $item)
                        @php
                            $j++;
                        @endphp
                    <tr>
                        <td style="border: 1px solid #a3a3a3; font-size:12px; padding:5px;text-align:center;text-transform: uppercase"> {{$j}}</td>
                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-transform: uppercase"> {{$item->payMethod->method}} </td>

                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:center;text-transform: uppercase">{{date('Y-m-d', strtotime($item->paid_date))}}</td>
                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right;text-transform: uppercase">{{$item->amount}}</td>
                    </tr>
                   @endforeach

                    <tr style="background-color:#a3a3a3; color:#fff">
                        <td colspan="3" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">Total Paid</td>
                        <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">{{ number_format($invoice->invoicePayment->sum('amount'),2,'.','')}}</td>
                    </tr>

                    <tr style="background-color:#a3a3a3; color:#fff">
                        <td colspan="3" style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">Due Amount</td>
                        <td  style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase">{{number_format(($invoice->sub_total - $invoice->disc_amount - $invoice->invoicePayment->sum('amount')),2,'.','')}}</td>
                    </tr>
            </table>
        @endif

    </div>

</body>
</html>
