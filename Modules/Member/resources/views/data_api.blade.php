@extends('layouts.app')

@push('styles')
    <style>
        /* Animasi untuk baris tabel */
        .row-animate {
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.5s ease-out;
        }

        .row-animate.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Estetika tambahan */
        .table-wrapper {
            border-radius: 12px;
            overflow: hidden;
        }

        .img-thumbnail {
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h2 class="fw-bold mb-4">📦 Data Member (via API)</h2>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-3 text-end">
            <a href="{{ route('member.api.create.form') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Member via API
            </a>
        </div>

        {{-- Tabel --}}
        @if (is_array($data) && count($data) > 0)
            <div class="card shadow-sm p-3 table-wrapper">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Foto</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $member)
                                <tr class="row-animate" style="transition-delay: {{ $index * 100 }}ms;">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member['nama'] }}</td>
                                    <td>{{ $member['email'] }}</td>
                                    <td>{{ $member['alamat'] }}</td>
                                    <td>{{ $member['telepon'] }}</td>
                                    <td>
                                        @if (!empty($member['foto']))
                                            <img src="{{ asset('storage/' . $member['foto']) }}" alt="Foto"
                                                class="img-thumbnail shadow-sm" width="80">
                                        @else
                                            <span class="badge bg-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('member.api.edit.form', $member['id']) }}"
                                            class="btn btn-sm btn-warning me-1"> Edit</a>
                                        <form id="form-delete-{{ $member['id'] }}"
                                            action="{{ route('member.api.delete', $member['id']) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $member['id'] }}"> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-4">
                <i class="bi bi-exclamation-triangle"></i> Tidak ada data member dari API.
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Hilangkan notifikasi otomatis setelah 4 detik
        setTimeout(() => {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let fade = bootstrap.Alert.getOrCreateInstance(alert);
                fade.close();
            });
        }, 4000);

        // Animasi baris tabel saat load
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.row-animate');
            rows.forEach((row, i) => {
                setTimeout(() => {
                    row.classList.add('show');
                }, i * 100); // delay 100ms per row
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert2 konfirmasi hapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function (e) {
                const memberId = this.dataset.id;
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-' + memberId).submit();
                    }
                });
            });
        });
    </script>
@endpush