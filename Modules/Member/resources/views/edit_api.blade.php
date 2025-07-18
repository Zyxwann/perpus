@extends('layouts.app')

@push('styles')
    <style>
        .slide-down {
            opacity: 0;
            transform: translateY(-100px);
            transition: all 0.6s ease;
        }

        .slide-down.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h2 class="fw-bold mb-4">✏️ Edit Member (via API)</h2>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form --}}
        <div id="form-wrapper" class="card shadow-sm slide-down">
            <div class="card-body">
                <form action="{{ route('member.api.update', $member['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $member['nama']) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $member['email']) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                            required>{{ old('alamat', $member['alamat']) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                            value="{{ old('telepon', $member['telepon'] ?? '') }}">
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label><br>
                        @if (!empty($member['foto']))
                            <img src="{{ asset('storage/' . $member['foto']) }}" alt="Foto Lama" width="120"
                                class="img-thumbnail mb-2"><br>
                        @endif
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <img id="preview" src="#" alt="Preview" class="img-thumbnail mt-2"
                            style="display: none; max-width: 150px;">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">💾 Update</button>
                        <a href="{{ route('member.api.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Animasi saat halaman dibuka
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('form-wrapper');
            if (form) {
                setTimeout(() => {
                    form.classList.add('show');
                }, 100);
            }
        });

        // Preview gambar saat input foto diubah
        document.getElementById('foto').onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        };
    </script>
@endpush