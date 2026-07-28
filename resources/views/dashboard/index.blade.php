@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard SIKASIR</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5>Total Layanan</h5>
                <h2>{{ $totalLayanan }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5>Total Kategori</h5>
                <h2>{{ $totalKategori }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5>Total Transaksi</h5>
                <h2>{{ $totalTransaksi }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-danger mb-3">
            <div class="card-body">
                <h5>Pendapatan</h5>
                <h2>
                Rp {{ number_format($pendapatan,0,',','.') }}
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h4>Selamat Datang 👋</h4>

        <p>
            Selamat datang di Sistem Informasi Pencatatan Pemasukan Kasir (SIKASIR).
        </p>

        <p>
            Dashboard ini akan menampilkan informasi penting seperti jumlah barang,
            transaksi, dan pendapatan secara real-time.
        </p>
    </div>
</div>

@endsection