@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Kategori</h2>

   <a href="{{ route('categories.create') }}" class="btn btn-primary">
    + Tambah Kategori
    </a>

    
</div>

@if($categories->count())

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Aksi
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td>

    <a href="{{ route('categories.edit', $category) }}" 
       class="btn btn-warning btn-sm">
        Edit
    </a>


    <form action="{{ route('categories.destroy', $category) }}" 
          method="POST"
          class="d-inline">

        @csrf
        @method('DELETE')

        <button type="submit"
        class="btn btn-danger btn-sm"
        onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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
    Belum ada data kategori.
</div>

@endif

@endsection