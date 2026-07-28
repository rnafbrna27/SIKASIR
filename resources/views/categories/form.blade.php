<div class="mb-3">
    <label class="form-label">Nama Kategori</label>

    <input
        type="text"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        placeholder="Masukkan nama kategori"
        value="{{ old('name', $category->name ?? '') }}">

    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>

    <textarea
        name="description"
        class="form-control"
        rows="4"
        placeholder="Masukkan deskripsi">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">
    Simpan
</button>

<a href="{{ route('categories.index') }}" class="btn btn-secondary">
    Kembali
</a>