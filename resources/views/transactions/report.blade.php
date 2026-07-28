@extends('layouts.app')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">
 <h2>
        Riwayat Transaksi
    </h2>

    <a
        href="{{ route('transactions.pdf') }}"
        class="btn btn-danger">

        Export PDF

    </a>

</div>
<form method="GET" class="row mb-4">

    <div class="col-md-3">

        <label>Dari</label>

        <input
            type="date"
            name="from"
            value="{{ request('from') }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label>Sampai</label>

        <input
            type="date"
            name="to"
            value="{{ request('to') }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label>Status</label>

        <select
            name="status"
            class="form-select">

            <option value="">
                Semua
            </option>

            <option
                value="Lunas"
                {{ request('status') == 'Lunas' ? 'selected' : '' }}>
                Lunas
            </option>

            <option
                value="Belum Lunas"
                {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>
                Belum Lunas
            </option>

        </select>

    </div>

    <div class="col-md-3 d-flex align-items-end">

        <button class="btn btn-primary w-100">

            Tampilkan

        </button>

    </div>

</form>
<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-primary">

            <div class="card-body">

                <h6>Total Transaksi</h6>

                <h3>

                    {{ $totalTransaksi }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-success">

            <div class="card-body">

                <h6>Pendapatan</h6>

                <h5>

                    Rp {{ number_format($totalPendapatan,0,',','.') }}

                </h5>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-warning">

            <div class="card-body">

                <h6>Piutang</h6>

                <h5>

                    Rp {{ number_format($belumLunas,0,',','.') }}

                </h5>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-info">

            <div class="card-body">

                <h6>Transaksi Lunas</h6>

                <h5>

                    Rp {{ number_format($lunas,0,',','.') }}

                </h5>

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header bg-primary text-white">
        Daftar Transaksi
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th>Invoice</th>

                    <th>Tanggal</th>

                    <th>Pelanggan</th>

                    <th>Total</th>

                    <th>Status</th>

                    <th width="100">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($transactions as $transaction)
                @php

                $dibayar = $transaction->payments->sum('amount');

                $sisa = $transaction->total - $dibayar;

                @endphp
                <tr>

                    <td>{{ $transaction->invoice }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
                    </td>

                    <td>{{ $transaction->customer_name }}</td>

                    <td>
                        Rp {{ number_format($transaction->total,0,',','.') }}
                    </td>
                    <td>
                        Rp {{ number_format($dibayar,0,',','.') }}
                    </td>

                    <td>
                        Rp {{ number_format($sisa,0,',','.') }}
                    </td>
                    <td>

                        @if($transaction->payment_status == 'Lunas')

                            <span class="badge bg-success">
                                Lunas
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Belum Lunas
                            </span>

                        @endif

                    </td>

                    <td>

                        <a
                            href="{{ route('transactions.show', $transaction) }}"
                            class="btn btn-info btn-sm">

                            Detail

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Belum ada transaksi.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection