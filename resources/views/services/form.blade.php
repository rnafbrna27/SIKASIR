<div class="mb-3">
    <label class="form-label">Nama Layanan</label>
    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name', $service->name ?? '') }}"
           required>
</div>
<div class="mb-3">
    <label class="form-label">Kategori</label>

    <select name="category_id" class="form-select" required>

        <option value="">-- Pilih Kategori --</option>

        @foreach($categories as $category)

            <option value="{{ $category->id }}"
                @selected(old('category_id', $service->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>

        @endforeach

    </select>
</div>
<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number"
           name="price"
           class="form-control"
           value="{{ old('price', $service->price ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Satuan</label>
    <input type="text"
           name="unit"
           class="form-control"
           value="{{ old('unit', $service->unit ?? '') }}"
           placeholder="Contoh: Lembar, Meter, Pcs"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description"
              class="form-control"
              rows="3">{{ old('description', $service->description ?? '') }}</textarea>
</div>