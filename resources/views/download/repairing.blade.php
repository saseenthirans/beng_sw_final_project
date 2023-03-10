<!DOCTYPE html>
<html>

<head>
    <title>Repairing - {{ $repairing->ref_no }}</title>
</head>

<body>

    <div>
        <table border="0" width="100%">
            <tr>
                <td width="100%"
                    style="font-size: 22px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                    {{ $company->name }}
                </td>
            </tr>
            <tr>
                <td width="100%"
                    style="font-size: 11px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                    Address : {{ $company->address }}
                </td>
            </tr>
            <tr>
                <td width="100%"
                    style="font-size: 11px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                    Email Address : {{ $company->email }}
                </td>
            </tr>

            <tr>
                <td width="100%"
                    style="font-size: 11px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">
                    Contact : {{ $company->contact }}
                </td>
            </tr>

        </table>
        <hr>
        @php
            //Pay Status
            if ($repairing->paid_status == 0) {
                $pay_color = 'red';
                $pay_status = 'Not Paid';
            }

            if ($repairing->paid_status == 1) {
                $pay_color = 'yellow';
                $pay_status = 'Advance Paid';
            }

            if ($repairing->paid_status == 2) {
                $pay_color = 'green';
                $pay_status = 'Fully Paid';
            }

            //Repairing Status
            if ($repairing->status == 0) {
                $status_color = 'red';
                $status = 'Taken';
            }

            if ($repairing->status == 1) {
                $status_color = 'yellow';
                $status = 'Processing';
            }

            if ($repairing->status == 2) {
                $status_color = 'blue';
                $status = 'Ready to Collect';
            }

            if ($repairing->status == 3) {
                $status_color = 'green';
                $status = 'Collected';
            }
        @endphp
        <table border="0" width="100%" style="margin-top: 10px">
            <tr>
                <td width="100%"
                    style="font-size: 20px;font-weight: bold; font-family: sans-serif; text-align: right; text-transform: uppercase; color:{{ $pay_color }}">
                    {{ $pay_status }}</td>
            </tr>
        </table>

        <table border="0" width="100%" style="margin-top: 10px">
            <tr>
                <td width="100%"
                    style="font-size: 20px;font-weight: bold; font-family: sans-serif; text-align: right; text-transform: uppercase; color:{{ $status_color }}">
                    {{ $status }}</td>
            </tr>
        </table>

        <table border="0" width="100%" style="margin-top: 10px">
            <tr>
                <td width="100%"
                    style="font-size: 16px;font-weight: bold; font-family: sans-serif;text-transform: uppercase">
                    Reference No #{{ $repairing->ref_no }}</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 14px; font-family: sans-serif;text-transform: uppercase">Taken Date
                    : {{ date('l, F, jS, Y', strtotime($repairing->taken_date)) }}</td>
            </tr>

            @if ($repairing->status == 3)
            <tr>
                <td width="100%" style="font-size: 14px; font-family: sans-serif;text-transform: uppercase">Collected Date
                    : {{ date('l, F, jS, Y', strtotime($repairing->collected_at)) }}</td>
            </tr>
            @endif
        </table>

        <table border="0" width="100%" style="margin-top: 20px">
            <tr>
                <td width="100%"
                    style="font-size: 14px;font-weight: bold; font-family: sans-serif;text-transform: uppercase">
                    Customer Details</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 12px; font-family: sans-serif;text-transform: uppercase">
                    {{ $repairing->customer->name }}</td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 12px; font-family: sans-serif">{{ $repairing->customer->contact }}
                </td>
            </tr>
            <tr>
                <td width="100%" style="font-size: 12px; font-family: sans-serif;text-transform: lowercase">
                    {{ $repairing->customer->email }}</td>
            </tr>

        </table>

        <br>

        @if (count($repairing->repairItems))
            <h3 style="font-size: 18px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">Allocated
                Items</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="background-color: #a3a3a3; color:#fff">
                    <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase"
                        width="5%">#</th>
                    <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase"
                        width="45%">Item</th>
                    <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase"
                        width="10%">Qty</th>
                    <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase"
                        width="15%">Price</th>
                    <th style="border: 1px solid #a3a3a3; padding:5px; font-size:14px;text-transform: uppercase"
                        width="15%">Amount</th>
                </tr>


                @php
                    $i = 0;
                @endphp
                @foreach ($repairing->repairItems as $item)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td
                            style="border: 1px solid #a3a3a3; font-size:12px; padding:5px;text-align:center;text-transform: uppercase">
                            {{ $i }}</td>
                        <td style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-transform: uppercase">
                            {{ $item->product->name }} </td>

                        <td
                            style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:center;text-transform: uppercase">
                            {{ $item->qty }}</td>
                        <td
                            style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right;text-transform: uppercase">
                            {{ $item->amount }}</td>
                        <td
                            style="border: 1px solid #a3a3a3;  font-size:12px; padding:5px;text-align:right;text-transform: uppercase">
                            {{ $item->total }}</td>
                    </tr>
                @endforeach
            </table>
            <br>
        @endif

        <h3 style="font-size: 18px;font-weight: bold; font-family: sans-serif; text-transform: uppercase">Payment
            Information</h3>
        <table width="100%" style="border-collapse: collapse; border: 0px;">

            <tr style="background-color:#a3a3a3; color:#fff">
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 80%">
                    Service Charge</td>
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 20%">
                    {{ number_format($repairing->charge, 2, '.', '') }}</td>
            </tr>
            @if (count($repairing->repairItems))
                <tr style="background-color:#a3a3a3; color:#fff">
                    <td
                        style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 80%">
                        Allocated Item Amount</td>
                    <td
                        style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 20%">
                        {{ number_format($repairing->repairItems->sum('amount'), 2, '.', '') }}</td>
                </tr>
            @endif

            <tr style="background-color:#a3a3a3; color:#fff">
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 80%">
                    Total Amount</td>
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 20%">
                    {{ number_format($repairing->amount, 2, '.', '') }}</td>
            </tr>

            <tr style="background-color:#a3a3a3; color:#fff">
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 80%">
                    Paid Amount</td>
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 20%">
                    {{ number_format($repairing->adv_amount, 2, '.', '') }}</td>
            </tr>

            <tr style="background-color:#a3a3a3; color:#fff">
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 80%">
                    Due Amount</td>
                <td
                    style="border: 1px solid #a3a3a3; font-size:14px; padding:5px; font-weight:bold; text-align:right;text-transform: uppercase; width: 20%">
                    {{ number_format(($repairing->amount - $repairing->adv_amount), 2, '.', '') }}</td>
            </tr>

        </table>

    </div>

</body>

</html>
