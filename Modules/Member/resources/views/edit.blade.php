@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg animate__animated animate__slideInDown">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">Edit Member</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('member.update', $member->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ $member->nama }}"
                                    required>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $member->email }}" required>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control"
                                    value="{{ $member->alamat }}">
                            </div>

                            {{-- Telepon --}}
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" name="telepon" id="telepon" class="form-control"
                                    value="{{ $member->telepon }}">
                            </div>

                            {{-- Foto --}}
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                                @if ($member->foto)
                                    <img src="{{ asset('storage/' . $member->foto) }}" width="100" class="img-thumbnail mt-2">
                                @endif
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="{{ route('member.index') }}" class="btn btn-secondary" id="btnKembali">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnKembali = document.getElementById('btnKembali');
            const cardForm = document.querySelector('.card');

            btnKembali.addEventListener('click', function (e) {
                e.preventDefault(); // cegah langsung pindah

                cardForm.classList.remove('animate__slideInDown');
                cardForm.classList.add('animate__slideOutUp');

                setTimeout(() => {
                    window.location.href = btnKembali.href;
                }, 800);
            });
        });
    </script>
@endsection