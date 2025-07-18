@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Tambah animasi slide in dari atas --}}
                <div class="card shadow-lg animate__animated animate__slideInDown">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Tambah Member</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('member.send-to-api') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control">
                            </div>

                            {{-- Telepon --}}
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" name="telepon" id="telepon" class="form-control">
                            </div>

                            {{-- Foto --}}
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
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

                // Tambahkan animasi keluar
                cardForm.classList.remove('animate__slideInDown');
                cardForm.classList.add('animate__slideOutUp');

                // Tunggu animasi selesai (durasi animate.css: 1s)
                setTimeout(() => {
                    window.location.href = btnKembali.href; // redirect setelah animasi selesai
                }, 800);
            });
        });
    </script>
@endsection