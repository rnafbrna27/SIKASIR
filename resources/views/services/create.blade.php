@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Tambah Layanan</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('services.store') }}" method="POST">

            @csrf

            @include('services.form')

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('services.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

@endsection