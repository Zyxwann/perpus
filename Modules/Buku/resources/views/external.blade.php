@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Buku dari API</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('buku.external.create') }}" class="btn btn-primary mb-3">+ Tambah Buku</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr class="text-center">
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Jumlah</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $index => $book)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $book['judul'] }}</td>
                    <td>{{ $book['penulis'] }}</td>
                    <td>{{ $book['penerbit'] }}</td>
                    <td class="text-center">{{ $book['tahun_terbit'] }}</td>
                    <td class="text-center">{{ $book['isbn'] }}</td>
                    <td class="text-center">{{ $book['jumlah'] }}</td>
                    <td class="text-center">
                        <img src="{{ $book['foto_url'] ?? asset('img/default.jpg') }}" 
                             alt="Sampul {{ $book['judul'] }}" 
                             class="img-thumbnail" 
                             style="width: 80px;">
                    </td>
                    <td class="text-center" style="width: 160px; white-space: nowrap;">
                        <a href="{{ route('buku.external.edit', ['id' => $book['id']]) }}" 
                           class="btn btn-sm btn-warning mb-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="{{ route('buku.external.delete', ['id' => $book['id']]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">Tidak ada data buku.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
