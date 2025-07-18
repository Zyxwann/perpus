@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Buku (Sumber Eksternal)</h4>
                </div>

                <div class="card-body">

                    {{-- Tampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Edit Buku --}}
                    <form action="{{ route('buku.external.update', ['id' => $book['id']]) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="isbn" value="{{ old('isbn', $book['isbn']) }}">

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control"
                                   value="{{ old('judul', $book['judul']) }}" required>
                        </div>

                        {{-- Penulis --}}
                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" name="penulis" id="penulis" class="form-control"
                                   value="{{ old('penulis', $book['penulis']) }}" required>
                        </div>

                        {{-- Penerbit --}}
                        <div class="mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" id="penerbit" class="form-control"
                                   value="{{ old('penerbit', $book['penerbit']) }}" required>
                        </div>

                        {{-- Tahun Terbit --}}
                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control"
                                   value="{{ old('tahun_terbit', $book['tahun_terbit']) }}"
                                   min="1000" max="{{ now()->year }}" required>
                        </div>

                        {{-- ISBN (readonly) --}}
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" id="isbn" class="form-control"
                                   value="{{ $book['isbn'] }}" readonly>
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Eksemplar</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control"
                                   value="{{ old('jumlah', $book['jumlah']) }}" min="1" required>
                        </div>

                        {{-- Ganti Foto --}}
                        <div class="mb-4">
                            <label for="foto" class="form-label">Ganti Foto Sampul (opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">

                            <div class="mt-2">
                                <small class="text-muted">PNG, JPG, atau JPEG • maks 2 MB</small><br>
                                <img src="{{ $book['foto_url'] ?? asset('img/default.jpg') }}"
                                     alt="Foto lama"
                                     class="img-thumbnail mt-1"
                                     style="width:90px;height:130px;object-fit:cover;">
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('buku.external') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
