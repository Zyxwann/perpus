@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Buku dari OpenLibrary</h2>
    <ul>
        @foreach ($books as $book)
            <li>
                <strong>{{ $book['judul'] }}</strong> oleh {{ $book['penulis'] }} ({{ $book['tahun_terbit'] }})<br>
                ISBN: {{ $book['isbn'] }} | Penerbit: {{ $book['penerbit'] }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
