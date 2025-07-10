@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Daftar Buku</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">+ Tambah Buku</a>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>ISBN</th>
                    <th>Jumlah</th>
                     <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->penulis }}</td>
                        <td>{{ $b->penerbit }}</td>
                        <td>{{ $b->tahun_terbit }}</td>
                        <td>{{ $b->isbn }}</td>
                        <td>{{ $b->jumlah }}</td>
                                                <td>
                            @if($b->foto)
                                <img src="{{ asset('uploads/foto_buku/' . $b->foto) }}" alt="Foto Buku" width="80" />
                            @else
                    -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('buku.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('buku.destroy', $b->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="6" class="text-center">Belum ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection