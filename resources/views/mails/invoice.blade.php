@extends('layouts.mail')

@section('body')

<tr>
    <td align="center" valign="top">
        <table bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" style="padding:60px 0px 60px;" width="800">
                            <tbody>
                                <tr>
                                    <td align="center" class="alg_center" valign="top">
                                        <p style="color:#3c3f5a; font-size:16px; font-weight:300; margin:12px 0px 0px; text-transform:uppercase; letter-spacing:2px; line-height:24px">
                                            Hi {{$name}}, <br>
                                            Here your Invoice Summery and Payments Details
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" class="alg_center" valign="top">
                                        <p style="color:#3c3f5a; font-size:16px; font-weight:600; margin:0px 0px; text-transform:uppercase; letter-spacing:2px; line-height:24px">
                                            {{date('l, F, jS, Y', strtotime($invoice->invoice_date))}}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <table style="border-radius:4px;" bgcolor="#29274c" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                            <tbody>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" class="alg_center" valign="top">
                                                                        <p style="color:#fff; font-size:14px; font-weight:600; margin:12px 0px 12px; text-transform: uppercase">
                                                                            Invoice Summary
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 0px 0px;" align="center" valign="top">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" style="padding:0px;" width="560">
                                            <tbody>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table style="border-radius:4px;" bgcolor="#fff" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:20px 20px 0px;" align="left" class="alg_center" valign="top">
                                                                        <p style="color:#46485d; font-size:13px; font-weight:600; margin:0px; text-transform: uppercase">
                                                                            Invoice # {{$invoice->ref_no}}
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table style="border-radius:4px;" bgcolor="#fff" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:10px 20px 10px;" align="left" class="alg_center" valign="top">
                                                                        <p style="color:#46485d; font-size:13px; font-weight:600; margin:0px; text-transform: uppercase">
                                                                            Invoice Date : {{date('l, F, jS, Y', strtotime($invoice->invoice_date))}}
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                        <table style="border-radius:4px;" bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="height:4px;" align="left" class="alg_center" valign="top">

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style="border-radius:4px;" bgcolor="#fff" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:20px 20px 10px;" align="left" class="alg_center" valign="top">
                                                                        <p style="color:#46485d; font-size:13px; font-weight:600; margin:0px; text-transform: uppercase">
                                                                            Item Summery
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:4px 20px" align="left" class="alg_center" valign="top">
                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="45%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#46485d; font-size:11px; font-weight:400; margin:0px;text-transform: uppercase">
                                                                                            Product:
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="20%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top">
                                                                                        <p style="color:#46485d; font-size:11px; font-weight:400; margin:0px ;text-transform: uppercase">
                                                                                            Qty:
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="35%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="right" class="alg_center" valign="top">
                                                                                        <p style="color:#46485d; font-size:11px; font-weight:400; margin:0px; text-transform: uppercase">
                                                                                            Amount:
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style="border-radius:4px;" bgcolor="#fff" align="center" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <!-- Foreach -->
                                                                @php
                                                                    $i = 0;
                                                                @endphp
                                                                @foreach ($invoice->invoiceItems as $item)
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                    <tr>
                                                                        <td align="center" class="alg_center" valign="top">
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="padding:7px 20px 0px" align="center" class="alg_center" valign="top">
                                                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="45%">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="left" class="alg_center" valign="top">
                                                                                                            <p style="color:#616268; font-size:13px; font-weight:600; margin:0px;">
                                                                                                                {{$item->product->name}}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="20%">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center" valign="top">
                                                                                                            <p style="color:#616268; font-size:13px; font-weight:600; margin:0px;">
                                                                                                                {{$item->qty. ' x '.$item->amount}}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="35%">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="right" class="alg_center" valign="top">
                                                                                                            <p style="color:#616268; font-size:13px; font-weight:600; margin:0px;">
                                                                                                                {{$item->total}}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                 <!-- Foreach END -->

                                                            </tbody>
                                                        </table>
                                                        <table style="border-radius:4px;" bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="height:4px;" align="left" class="alg_center" valign="top">

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style="border-radius:4px;" bgcolor="#fff" align="center" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" class="alg_center" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:18px 20px 0px" align="left" class="alg_center" valign="top">
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                                        <p style="color:#46485d; font-size:13px; font-weight:600; margin:0px; text-transform: uppercase">
                                                                                                            Payment:
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="alg_center" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:10px 20px 0px" align="left" class="alg_center" valign="top">
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            Sub-Total
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="right" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            {{ number_format(($invoice->sub_total),2,'.','')}}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="alg_center" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:10px 20px 0px" align="left" class="alg_center" valign="top">
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            Discount
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="right" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            {{number_format(($invoice->disc_amount),2,'.','')}}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="alg_center" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:10px 20px 0px" align="left" class="alg_center" valign="top">
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            Total
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="right" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            {{number_format(($invoice->sub_total - $invoice->disc_amount),2,'.','')}}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="alg_center" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:10px 20px 0px" align="left" class="alg_center" valign="top">
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            Paid Amount
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="right" class="alg_center" valign="top">
                                                                                                        <p style="color:#616268; font-size:13px; font-weight:500; margin:0px;">
                                                                                                            @php
                                                                                                                $paid_amount = $invoice->invoicePayment->sum('amount');
                                                                                                            @endphp
                                                                                                            {{number_format(($paid_amount),2,'.','')}}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="alg_center" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:10px 20px 20px" align="left" class="alg_center" valign="top">
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                                        <p style="color:#000; font-size:14px; font-weight:800; margin:0px; text-transform:uppercase;">
                                                                                                            Due Amount
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="wrap-nopadding" width="50%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="right" class="alg_center" valign="top">
                                                                                                        <p style="color:#000; font-size:14px; font-weight:800; margin:0px;">
                                                                                                            {{number_format(($invoice->sub_total - $invoice->disc_amount - $paid_amount),2,'.','')}}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style="border-radius:4px; margin-bottom: 50px" bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="height:20px;" align="left" class="alg_center" valign="top">

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>

@endsection
