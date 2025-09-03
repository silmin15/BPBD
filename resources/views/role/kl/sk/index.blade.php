@extends('layouts.app_admin')

@section('title', 'Data SK (KL)')
@section('page_title', 'Data SK')
@section('page_icon') <i class="bi bi-file-earmark-text"></i> @endsection
@section('page_actions')
    <a href="{{ route('kl.sk.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah SK</a>
@endsection

@section('content')
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No SK</th>
                        <th>Judul SK</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Tanggal SK</th>
                        <th>PDF</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list as $i=>$sk)
                        <tr>
                            <td>{{ $list->firstItem() + $i }}</td>
                            <td>{{ $sk->no_sk }}</td>
                            <td>{{ $sk->judul_sk }}</td>
                            <td>
                                @if ($sk->start_at)
                                    {{ $sk->start_at->format('d/m/Y') }}
                                @endif —
                                @if ($sk->end_at)
                                    {{ $sk->end_at->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $cls = match ($sk->status_label) {
                                        'Aktif' => 'badge bg-success',
                                        'Belum Berlaku' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary',
                                    };
                                @endphp
                                <span class="{{ $cls }}">{{ $sk->status_label }}</span>
                            </td>
                            <td>{{ $sk->tanggal_sk->translatedFormat('d F Y') }}</td>
                            <td>
                                <a href="{{ route('kl.sk.download', $sk) }}" class="link-primary"><i
                                        class="bi bi-file-earmark-pdf"></i> Unduh</a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('kl.sk.edit', $sk) }}">Edit</a>
                                <form action="{{ route('kl.sk.destroy', $sk) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus SK ini?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $list->links() }}</div>
    </div>
@endsection
