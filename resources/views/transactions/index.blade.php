@extends('layouts.app')

@section('content')

<h2 class="mb-4">Transaksi Kasir</h2>

<div class="row">

    {{-- Daftar Layanan --}}
    <div class="col-md-6">

        <div class="card">

            <div class="card-header bg-primary text-white">
                Daftar Layanan
            </div>

            <div class="card-body">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($services as $service)

                        <tr>

                            <td>{{ $service->name }}</td>

                            <td>
                                Rp {{ number_format($service->price,0,',','.') }}
                            </td>

                            <td>

                        <form action="{{ route('cart.add', $service) }}" method="POST">

                          @csrf

                         <button class="btn btn-success btn-sm">

                              +

                         </button>

                        </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="3" class="text-center">
                                Belum ada data.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Keranjang --}}
    <div class="col-md-6">

        <div class="card">

            <div class="card-header bg-success text-white">
                Keranjang
            </div>

            <div class="card-body">

                        @php
                $cart = session('cart', []);
                $total = 0;
            @endphp

            @if(count($cart))

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($cart as $item)

                @php
                    $total += $item['subtotal'];
                @endphp

                <tr>

                    <td>{{ $item['name'] }}</td>

                    <td width="140">

    <form
        action="{{ route('cart.update', $item['service_id']) }}"
        method="POST">

        @csrf
        @method('PATCH')

        <input
            type="number"
            name="qty"
            class="form-control form-control-sm"
            value="{{ $item['qty'] }}"
            min="1"
            onchange="this.form.submit()">

    </form>

</td>

                    <td>
                        Rp {{ number_format($item['subtotal'],0,',','.') }}
                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            @else

            <div class="alert alert-secondary">

                Keranjang masih kosong.

            </div>

            @endif

                <hr>

                <h4 class="text-end">

                    Total :
                   <strong id="grandTotal"
        data-total="{{ $total }}">

Rp {{ number_format($total,0,',','.') }}

</strong>

                </h4>

                <hr>

<form action="{{ route('transactions.store') }}" method="POST">

    @csrf

    <div class="mb-3">

        <label class="form-label">
    Nama Pelanggan
</label>

<input
    type="text"
    name="customer_name"
    class="form-control"
    placeholder="Masukkan nama pelanggan"
    required>

    </div>

    <div class="mb-3">

    <label class="form-label">
        Deskripsi / Keterangan
    </label>

    <textarea
        name="notes"
        class="form-control"
        rows="3"
        placeholder="Contoh: Nama surpol, akte, kk, dll."></textarea>

</div>

    <div class="mb-3">

        <label class="form-label">
            Metode Pembayaran
        </label>

        <select
    name="payment_method"
    class="form-select">

    <option value="Tunai">Tunai</option>
    <option value="Transfer">Transfer</option>
    <option value="QRIS">QRIS</option>

    </select>

    </div>

   <div class="mb-3">

    <label class="form-label">
        Nominal Dibayar
    </label>

    <input
        type="number"
        id="paid"
        name="amount"
        class="form-control"
        placeholder="0"
        value="0"
        min="0">

</div>

    <div class="mb-3">

    <label class="form-label">
        Status Pembayaran
    </label>

    <input
        type="text"
        id="status"
        class="form-control"
        value="Belum Ada Pembayaran"
        readonly>

</div>

<div class="mb-3">

    <label class="form-label">
        Sisa / Kembalian
    </label>

    <input
        type="text"
        id="sisa"
        class="form-control"
        value="Rp 0"
        readonly>

</div>
    <input
    type="hidden"
    name="total"
    value="{{ $total }}">
    <button
    type="submit"
    class="btn btn-primary w-100">

    Simpan Transaksi

</button>

</form>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const total = Number(document.getElementById('grandTotal').dataset.total);

const paid = document.getElementById('paid');

const status = document.getElementById('status');

const sisa = document.getElementById('sisa');

paid.addEventListener('input', function () {

    let bayar = Number(this.value);

    if (bayar == 0){

        status.value = "Belum Ada Pembayaran";
        sisa.value = "Rp 0";
        return;

    }

    if (bayar >= total){

        status.value = "LUNAS";

        sisa.value = "Kembalian Rp " + (bayar-total).toLocaleString('id-ID');

    }else{

        status.value = "BELUM LUNAS";

        sisa.value = "Sisa Rp " + (total-bayar).toLocaleString('id-ID');

    }

});

</script>

@endpush