@extends('layouts.app')

@section('content')
    <h2>Daftar Buku</h2>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $index => $b)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $b->judul }}</td>
                    <td>{{ $b->penulis }}</td>
                    <td>{{ $b->tahun_terbit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection