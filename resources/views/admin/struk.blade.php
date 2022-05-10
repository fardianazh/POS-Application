<!DOCTYPE html>
<html lang="en">
<head>
    <title>Struk</title>
    <style>
        body{
            font-family: arial;
        }
        .container{
            width: 25%;
            min-height: 400px;
            border: 1px dashed #ddd;
        }
        .tagline{
            text-align: center;
            font-size: 12px;
            margin-top: -15px;
        }

        tr:nth-child(even){
            background-color: #ddd;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h2 align="center">BajuKu</h2>
        <p class="tagline">Jl. Buah Batu No.49/207 A</p>

        <table border="1" cellspacing="0" align="center" width="90%" style="font-size: 12px">
            <tr>
                <td><strong> Date </strong></td>
                <td>{{ date('d-m-y') }}</td>
            </tr>
            <tr>
                <td><strong> Employee </strong></td>
                <td>{{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong> No Invoice </strong></td>
                <td>{{ request()->segment(3) }}</td>
            </tr>
        </table>

        <table border="1" cellspacing="0" align="center" width="90%" style="font-size: 12px; margin-top: 20px;">
            <tr>
                <td colspan="7"><strong>Transaction Details</strong></td>
            </tr>
            <tr>
                <td><strong> No</strong></td>
                <td><strong> Name Product</strong></td>
                <td><strong> Price</strong></td>
                <td><strong> Qty</strong></td>
                <td><strong> Total Price</strong></td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach($transactions as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ rupiah($item->product->price) }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ rupiah($item->total_price) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>Payment</strong></td>
                <td>{{ rupiah($transactionDetails->payment) }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Total Payment</strong></td>
                <td>{{ rupiah($transactionDetails->total_payment) }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Change</strong></td>
                <td>{{ rupiah($transactionDetails->change) }}</td>
            </tr>
        </table>

        <p style="text-align: center; font-size: 12px; margin-top: 50px">Cant returned that stuff you buy!</p>
        <p style="text-align: center; font-size: 12px">--- Thanks ! ----</p>
    </div>

</body>
</html>