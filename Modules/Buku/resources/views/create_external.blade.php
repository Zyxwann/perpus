@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Buku (Sumber Eksternal)</h4>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('buku.external.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="judul">Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="penulis">Penulis</label>
                            <input type="text" name="penulis" id="penulis" class="form-control" value="{{ old('penulis') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="penerbit">Penerbit</label>
                            <input type="text" name="penerbit" id="penerbit" class="form-control" value="{{ old('penerbit') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}" min="1000" max="{{ now()->year }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="isbn">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" value="{{ old('isbn') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah', 1) }}" min="1" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="foto">Foto Buku</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('buku.external') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
