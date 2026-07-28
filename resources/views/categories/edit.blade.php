@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Edit Kategori</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('categories.update', $category) }}" method="POST">

            @csrf

            @method('PUT')

            @include('categories.form')

        </form>

    </div>
</div>

@endsection