@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Layanan</h2>

    <a href="{{ route('services.create') }}" class="btn btn-primary">
        + Tambah Layanan
    </a>
</div>

@if($services->count())

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Satuan</th>
            <th>Aksi</th>

        </tr>
    </thead>

    <tbody>
        @foreach($services as $service)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $service->name }}</td>

            <td>
            <span class="badge bg-primary">
                {{ $service->category->name }}
            </span>
            </td>

            <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>

            <td>{{ $service->unit }}</td>

            <td>
                <a href="{{ route('services.edit', $service) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('services.destroy', $service) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus layanan ini?')">
                        Hapus
                    </button>

                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@else

<div class="alert alert-warning">
    Belum ada data layanan.
</div>

@endif

@endsection