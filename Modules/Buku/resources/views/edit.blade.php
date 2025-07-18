@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Edit Buku</h2>

<form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" required
            value="{{ old('judul', $buku->judul) }}">
    </div>

    <div class="mb-3">
        <label for="penulis" class="form-label">Penulis</label>
        <input type="text" class="form-control" id="penulis" name="penulis" required
            value="{{ old('penulis', $buku->penulis) }}">
    </div>

    <div class="mb-3">
        <label for="penerbit" class="form-label">Penerbit</label>
        <input type="text" class="form-control" id="penerbit" name="penerbit" required
            value="{{ old('penerbit', $buku->penerbit) }}">
    </div>

    <div class="mb-3">
        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required
            value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
    </div>

    <div class="mb-3">
        <label for="isbn" class="form-label">ISBN</label>
        <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $buku->isbn) }}">
    </div>

    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" required
            value="{{ old('jumlah', $buku->jumlah) }}">
    </div>

    <div class="mb-3">
        <label for="foto" class="form-label">Foto Buku</label>
        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        @if($buku->foto)
            <div class="mt-2">
                <img src="{{ asset('uploads/foto_buku/' . $buku->foto) }}" alt="Foto Buku" width="120">
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection