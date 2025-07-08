@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Member</h2>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('member.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('member::_form', ['member' => $member])
        <button type="submit">Perbarui</button>
    </form>

    <a href="{{ route('member.index') }}">← Kembali ke daftar member</a>
</div>
@endsection
