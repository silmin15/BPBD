@extends('layouts.app_admin')

@section('title', 'Data & Rekap SK')
@section('page_title', 'Data & Rekap SK')
@section('page_icon') <i class="bi bi-journal-text"></i> @endsection

@section('page_actions')
    @if ($activeTab === 'data')
        <a href="{{ route($routeBase . '.sk.create') }}" class="btn-orange">
            <i class="bi bi-plus-lg"></i> Tambah SK
        </a>
    @else
        {{-- Aksi untuk tab Rekap --}}
        @if (Route::has($routeBase . '.sk.rekap.years'))
            <a href="{{ route($routeBase . '.sk.rekap.years') }}" class="btn btn-warning me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        @endif

        <button type="submit" class="btn-gray" id="top-print-selected" form="form-selected" formtarget="_blank" disabled>
            <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
        </button>
    @endif
@endsection

@section('content')
    <div class="container-fluid px-0">

        {{-- Tabs switcher --}}
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route($routeBase . '.sk.index', ['tab' => 'data']) }}"
                class="btn {{ $activeTab === 'data' ? 'btn-primary' : 'btn-outline-primary' }}">
                Data SK
            </a>

            <a href="{{ route($routeBase . '.sk.index', ['tab' => 'rekap', 'year' => $year]) }}"
                class="btn {{ $activeTab === 'rekap' ? 'btn-primary' : 'btn-outline-primary' }}">
                Rekap SK
            </a>

            @if ($activeTab === 'rekap')
                {{-- pilih tahun (mirip rekap-years → tetap di halaman ini) --}}
                <div class="ms-auto">
                    <form method="GET" action="{{ route($routeBase . '.sk.index') }}" class="d-inline">
                        <input type="hidden" name="tab" value="rekap">
                        <select name="year" class="form-select form-select-sm d-inline w-auto"
                            onchange="this.form.submit()">
                            @for ($y = now()->year + 1; $y >= now()->year - 6; $y--)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>
            @endif
        </div>

        {{-- ============================== TAB: DATA ============================== --}}
        <div class="{{ $activeTab === 'data' ? '' : 'd-none' }}">
            <div class="table-card overflow-x-auto">
                <table class="bpbd-table min-w-full">
                    <thead>
                        <tr>
                            <th class="text-start">#</th>
                            <th class="text-start">No SK</th>
                            <th class="text-start">Judul SK</th>
                            <th class="text-center">Masa Berlaku</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal SK</th>
                            <th class="text-center">PDF</th>
                            <th class="col-aksi text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($list as $i => $sk)
                            <tr>
                                <td class="text-start">{{ $list->firstItem() + $i }}</td>
                                <td class="fw-semibold text-start">{{ $sk->no_sk }}</td>
                                <td class="text-start">{{ $sk->judul_sk }}</td>

                                <td class="text-center text-nowrap">
                                    {{ $sk->start_at?->format('d/m/Y') }} — {{ $sk->end_at?->format('d/m/Y') }}
                                </td>

                                <td class="text-center">
                                    @php $expired = $sk->end_at && now()->gt($sk->end_at); @endphp
                                    <span class="badge {{ $expired ? 'bg-secondary' : 'bg-success' }}">
                                        {{ $expired ? 'Tidak Aktif' : 'Aktif' }}
                                    </span>
                                </td>

                                <td class="text-center">{{ $sk->tanggal_sk->format('d/m/Y') }}</td>

                                <td class="text-center">
                                    @if ($sk->pdf_path)
                                        <a href="{{ route($routeBase . '.sk.download', $sk) }}" target="_blank"
                                            class="text-danger d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-file-pdf"></i>
                                            <span class="d-none d-sm-inline">Unduh</span>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="text-center text-nowrap">
                                    <a href="{{ route($routeBase . '.sk.edit', $sk) }}" class="btn-edit me-1">Edit</a>
                                    <form action="{{ route($routeBase . '.sk.destroy', $sk) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus SK ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-slate-500 py-6">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $list->withQueryString()->onEachSide(1)->links() }}
            </div>
        </div>

        {{-- ============================== TAB: REKAP ============================= --}}
        <div class="{{ $activeTab === 'rekap' ? '' : 'd-none' }}">
            <form method="GET" action="{{ route($routeBase . '.sk.rekap.pdf', $year) }}" target="_blank"
                id="form-selected" class="mb-3">

                <div class="d-flex align-items-center gap-3 mb-2 flex-wrap">
                    <label class="form-check d-inline-flex align-items-center gap-2 mb-0">
                        <input type="checkbox" id="check-all" class="form-check-input">
                        <span>Pilih semua</span>
                    </label>
                    <div class="ms-auto">
                        <span class="text-muted">Tahun:</span> <strong>{{ $year }}</strong>
                    </div>
                    <button type="submit" class="btn-gray" id="top-print-selected" formtarget="_blank" disabled>
                        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
                    </button>
                </div>

                <div class="table-card overflow-x-auto">
                    <table class="bpbd-table min-w-full">
                        <thead>
                            <tr>
                                <th width="36">#</th>
                                <th class="text-start">No SK</th>
                                <th class="text-start">Judul SK</th>
                                <th class="text-center">Tanggal SK</th>
                                <th class="text-center">Masa Berlaku</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($byMonth as $ym => $rows)
                                <tr class="table-subheader">
                                    <td colspan="7" class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($ym . '-01')->translatedFormat('F Y') }}
                                    </td>
                                </tr>

                                @foreach ($rows as $sk)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="row-check" name="selected_ids[]"
                                                value="{{ $sk->id }}">
                                        </td>
                                        <td class="fw-semibold text-start">{{ $sk->no_sk }}</td>
                                        <td class="text-start">{{ $sk->judul_sk }}</td>
                                        <td class="text-center">{{ $sk->tanggal_sk->format('d/m/Y') }}</td>
                                        <td class="text-center text-nowrap">
                                            {{ $sk->start_at?->format('d/m/Y') }} — {{ $sk->end_at?->format('d/m/Y') }}
                                        </td>
                                        <td class="text-center">
                                            @php $expired = $sk->end_at && now()->gt($sk->end_at); @endphp
                                            <span class="badge {{ $expired ? 'bg-secondary' : 'bg-success' }}">
                                                {{ $expired ? 'Kedaluwarsa' : 'Aktif' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($sk->pdf_path)
                                                <a href="{{ route($routeBase . '.sk.download', $sk) }}" target="_blank"
                                                    class="text-danger d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-file-pdf"></i>
                                                    <span class="d-none d-sm-inline">Unduh</span>
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-slate-500 py-6">
                                        Belum ada data pada tahun ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn-gray" id="bottom-print-selected" disabled>
                        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
