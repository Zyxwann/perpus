@extends('layouts.app') {{-- atau layout yang kamu pakai --}}

@section('content')
    <form action="{{ route('member.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat:</label>
            <textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

@endsection