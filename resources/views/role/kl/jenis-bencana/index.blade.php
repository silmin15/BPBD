@extends('layouts.app_admin')

@section('title', 'Daftar Jenis Bencana')

@section('content')
<div class="container">
    <h1>Daftar Jenis Bencana</h1>

    <a href="{{ route('kl.jenis-bencana.create') }}" class="btn btn-primary mb-3">Tambah Jenis Bencana</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-card overflow-x-auto">
        <table class="bpbd-table min-w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Ikon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jenisBencanas as $jenis)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jenis->nama }}</td>
                    <td>
                        @if($jenis->ikon)
                        <i class="{{ $jenis->ikon }}" style="font-size: 1.5rem;"></i>
                        @else
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('kl.jenis-bencana.edit', $jenis->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kl.jenis-bencana.destroy', $jenis->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection