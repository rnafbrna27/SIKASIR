@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Layanan</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $service->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Layanan</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $service->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           value="{{ old('price', $service->price) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text"
                           name="unit"
                           class="form-control"
                           value="{{ old('unit', $service->unit) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $service->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('services.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>
@endsection