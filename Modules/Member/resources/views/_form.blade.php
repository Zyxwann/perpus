<div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $member->nama ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $member->email ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea name="alamat" id="alamat" class="form-control" rows="3"
        required>{{ old('alamat', $member->alamat ?? '') }}</textarea>
</div>