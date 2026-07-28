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
    border:1px solid #000;
}

th, td{
    padding:8px;
}

.text-right{
    text-align:right;
}

.text-center{
    text-align:center;
}

.no-border,
.no-border td{
    border:none;
}

.box{
    border:1px solid #000;
    padding:10px;
    margin-top:10px;
    margin-bottom:15px;
    white-space:pre-line;
}

</style>

</head>

<body>

<h2 class="text-center">
INVOICE SIKASIR
</h2>

<hr>

<table class="no-border">

<tr>

<td>

<b>Invoice</b><br>
{{ $transaction->invoice }}

</td>

<td>

<b>Tanggal</b><br>
{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}

</td>

</tr>

<tr>

<td>

<b>Pelanggan</b><br>
{{ $transaction->customer_name }}

</td>

<td>

<b>Status</b><br>
{{ $transaction->payment_status }}

</td>

</tr>

</table>

<br>

<table>

<thead>

<tr>

<th>Layanan</th>
<th width="60">Qty</th>
<th width="120">Harga</th>
<th width="140">Subtotal</th>

</tr>

</thead>

<tbody>

@foreach($transaction->details as $detail)

<tr>

<td>{{ $detail->service->name }}</td>

<td class="text-center">
{{ $detail->qty }}
</td>

<td class="text-right">
Rp {{ number_format($detail->price,0,',','.') }}
</td>

<td class="text-right">
Rp {{ number_format($detail->subtotal,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

<br>

@php

$totalBayar = $transaction->payments->sum('amount');
$sisa = $transaction->total - $totalBayar;

@endphp

<h3 class="text-right">

TOTAL

Rp {{ number_format($transaction->total,0,',','.') }}

</h3>

<table class="no-border">

<tr>
<td><b>Total Dibayar</b></td>
<td>:</td>
<td>Rp {{ number_format($totalBayar,0,',','.') }}</td>
</tr>

<tr>
<td><b>Sisa Tagihan</b></td>
<td>:</td>
<td>Rp {{ number_format($sisa,0,',','.') }}</td>
</tr>

</table>

{{-- ===================== --}}
{{-- DESKRIPSI --}}
{{-- ===================== --}}

@if(!empty($transaction->notes))

<h4>
Deskripsi / Keterangan
</h4>

<div class="box">

{{ $transaction->notes }}

</div>

@endif

{{-- ===================== --}}
{{-- RIWAYAT PEMBAYARAN --}}
{{-- ===================== --}}

@if($transaction->payments->count())

<h4>

Riwayat Pembayaran

</h4>

<table>

<thead>

<tr>

<th>Tanggal</th>
<th>Metode</th>
<th>Nominal</th>

</tr>

</thead>

<tbody>

@foreach($transaction->payments as $payment)

<tr>

<td>
{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}
</td>

<td>
{{ $payment->payment_method }}
</td>

<td class="text-right">
Rp {{ number_format($payment->amount,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

@endif

<br><br>

<p class="text-center">
Terima kasih telah menggunakan SIKASIR
</p>

</body>

</html>