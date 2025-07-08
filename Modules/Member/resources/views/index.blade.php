@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Member</h2>
        <form method="GET" action="{{ route('member.index') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari member..." />
            <button type="submit">Cari</button>
        </form>
        <a href="{{ route('member.create') }}">Tambah Member</a>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ $member->nama }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->alamat }}</td>
                        <td>
                            <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('member.destroy', $member->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $members->links() }}
    </div>
@endsection