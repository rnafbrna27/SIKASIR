@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Tambah Kategori</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('categories.store') }}" method="POST">

            @csrf

            @include('categories.form')

        </form>

    </div>
</div>

@endsection