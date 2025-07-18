@extends('layouts.app')
@push('styles')
    <style>
        .foto-hover:hover {
            transform: scale(1.05);
            transition: 0.3s ease;
        }
    </style>
@endpush

@push('styles')
    <style>
        .foto-hover:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
@endpush



@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">📋 Daftar Member</h2>
            <a href="{{ route('member.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Member
            </a>
        </div>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('member.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ $search }}" class="form-control"
                    placeholder="🔍 Cari nama atau email...">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </div>
        </form>

        {{-- Tabel Data --}}
        @if ($members->count())
            <div class="card shadow-sm animate__animated animate__fadeIn">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $index => $member)
                                <tr class="animate__animated animate__slideInDown"
                                    style="animation-delay: {{ $index * 0.1 }}s; animation-fill-mode: both;">
                                    <td>{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                                    <td>{{ $member->nama }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->alamat }}</td>
                                    <td>{{ $member->telepon }}</td>
                                    <td>
                                        @if ($member->foto && file_exists(public_path('storage/' . $member->foto)))
                                            <img src="{{ asset('storage/' . $member->foto) }}" alt="Foto" width="100"
                                                class="img-thumbnail shadow-sm border border-2 foto-hover">

                                        @else
                                            <span class="badge bg-secondary">Belum ada</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('member.edit', $member) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('member.destroy', $member) }}" method="POST"
                                            class="d-inline form-hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-konfirmasi">Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $members->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center mt-4">
                <i class="bi bi-info-circle"></i> Tidak ada data member ditemukan.
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // Script untuk auto-close alert
        setTimeout(() => {
            const alert = document.getElementById('flash-message');
            if (alert) {
                alert.classList.add('fade');
                alert.classList.remove('show');

                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }, 3000);

        // Script untuk konfirmasi hapus dengan SweetAlert2
        document.addEventListener('DOMContentLoaded', function () {
            const hapusButtons = document.querySelectorAll('.btn-konfirmasi');

            hapusButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const form = btn.closest('form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection