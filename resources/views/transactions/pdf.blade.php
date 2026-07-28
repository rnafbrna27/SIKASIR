<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        table{

            width:100%;
            border-collapse:collapse;

        }

        table, th, td{

            border:1px solid black;

        }

        th, td{

            padding:8px;

        }

        h2{

            text-align:center;

        }

    </style>

</head>

<body>

<h2>

LAPORAN TRANSAKSI SIKASIR

</h2>

<table>

<thead>

<tr>

<th>Invoice</th>

<th>Tanggal</th>

<th>Pelanggan</th>

<th>Total</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($transactions as $transaction)

<tr>

<td>{{ $transaction->invoice }}</td>

<td>{{ $transaction->transaction_date }}</td>

<td>{{ $transaction->customer_name }}</td>

<td>

Rp {{ number_format($transaction->total,0,',','.') }}

</td>

<td>

{{ $transaction->payment_status }}

</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>