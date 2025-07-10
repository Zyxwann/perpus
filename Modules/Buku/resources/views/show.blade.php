@extends('buku::layouts.master')

@section('content')
    <h2>Detail Buku</h2>

    <ul>
        <li><strong>Judul:</strong> {{ $buku->judul }}</li>
        <li><strong>Penulis:</strong> {{ $buku->penulis }}</li>
        <li><strong>Penerbit:</strong> {{ $buku->penerbit }}</li>
        <li><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</li>
        <li><strong>ISBN:</strong> {{ $buku->isbn }}</li>
        <li><strong>Jumlah:</strong> {{ $buku->jumlah }}</li>
    </ul>

    <a href="{{ route('buku.index') }}">Kembali</a>
@endsection