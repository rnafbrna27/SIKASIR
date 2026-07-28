@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Detail Transaksi
</h2>

<div class="card">

    <div class="card-header bg-primary text-white">
        Invoice : {{ $transaction->invoice }}
    </div>

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-6">
                <strong>Pelanggan :</strong><br>
                {{ $transaction->customer_name }}
            </div>

            <div class="col-md-6">
                <strong>Tanggal :</strong><br>
                {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
            </div>

        </div>

        @if(!empty($transaction->notes))

<div class="alert alert-info">

    <strong>Deskripsi / Keterangan</strong>

    <hr>

    <div style="white-space: pre-line;">
        {{ $transaction->notes }}
    </div>

</div>

@endif

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>

                    <th>Layanan</th>

                    <th width="80">Qty</th>

                    <th width="150">Harga</th>

                    <th width="170">Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($transaction->details as $detail)
            

                <tr>

                    <td>{{ $detail->service?->name ?? '-' }}</td>

                    <td>{{ $detail->qty }}</td>

                    <td>
                        Rp {{ number_format($detail->price,0,',','.') }}
                    </td>

                    <td>
                        Rp {{ number_format($detail->subtotal,0,',','.') }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <hr>

        <div class="row">

            <div class="col-md-6">

                <strong>Status Pembayaran</strong>

                <br>

                @if($transaction->payment_status == 'Lunas')

                    <span class="badge bg-success">
                        Lunas
                    </span>

                @else

                    <span class="badge bg-danger">
                        Belum Lunas
                    </span>

                @endif

            </div>

            <div class="col-md-6 text-end">

                <h4>

                    Total

                    <br>

                    <strong>

                        Rp {{ number_format($transaction->total,0,',','.') }}

                    </strong>

                </h4>

            </div>

        </div>

        <hr>
@php

$totalBayar = $transaction->payments->sum('amount');

$sisa = $transaction->total - $totalBayar;

@endphp

<div class="row mb-4">

    <div class="col-md-4">

        <div class="card border-success">

            <div class="card-body">

                <h6>Total Dibayar</h6>

                <h4 class="text-success">

                    Rp {{ number_format($totalBayar,0,',','.') }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-danger">

            <div class="card-body">

                <h6>Sisa Pembayaran</h6>

                <h4 class="text-danger">

                    Rp {{ number_format($sisa,0,',','.') }}

                </h4>

            </div>

        </div>

    </div>

</div>
@if($transaction->payment_status == 'Belum Lunas')

<hr>

<h5>Bayar Sisa</h5>

<form
    action="{{ route('transactions.payment', $transaction) }}"
    method="POST">

    @csrf

    <div class="mb-3">

        <label>Nominal Pembayaran</label>

        <input
            type="number"
            name="amount"
            class="form-control"
            min="1"
            max="{{ $sisa }}"
            required>

    </div>

    <div class="mb-3">

        <label>Metode Pembayaran</label>

        <select
            name="payment_method"
            class="form-select">

            <option>Tunai</option>
            <option>Transfer</option>
            <option>QRIS</option>

        </select>

    </div>

    <button class="btn btn-warning">

        Bayar Sisa

    </button>

</form>

@endif
        <h5>Pembayaran</h5>

        <table class="table table-bordered">

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

                    <td>

                        Rp {{ number_format($payment->amount,0,',','.') }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

       <a href="{{ route('transactions.invoice', $transaction) }}"
   class="btn btn-danger">
    Cetak PDF
</a>

<form action="{{ route('transactions.destroy', $transaction) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">

    @csrf
    @method('DELETE')

    <button class="btn btn-danger">
        Hapus Transaksi
    </button>

</form>
<a
    href="{{ route('transactions.report') }}"
    class="btn btn-secondary">

    Kembali

</a>

    </div>

</div>

@endsection