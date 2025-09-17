@extends('layouts.app_admin')

@section('title', 'Data & Rekap SK')
@section('page_title', 'Data & Rekap SK')
@section('page_icon') <i class="bi bi-journal-text"></i> @endsection

@php
    // Tentukan namespace route (admin|pk|kl|rr)
    $ns = $routeBase ?? (Route::is('pk.*') ? 'pk' : (Route::is('kl.*') ? 'kl' : (Route::is('rr.*') ? 'rr' : 'admin')));

    $isAdmin = $ns === 'admin';
    $q = trim(request('q', ''));
    $ownerRole = request('owner_role');

    // total untuk footer (menyerupai SOP)
    $totalData = isset($list) ? $list->total() ?? 0 : 0;
@endphp

{{-- Aksi kanan header ala SOP --}}
@section('page_actions')
    @if (($activeTab ?? 'data') === 'data')
        <a href="{{ route($ns . '.sk.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Tambah SK
        </a>
    @else
        @if (Route::has($ns . '.sk.rekap.years'))
            <a href="{{ route($ns . '.sk.rekap.years') }}" class="btn btn-warning me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        @endif
        <button type="submit" class="btn btn-outline-secondary" id="top-print-selected" form="form-selected"
            formtarget="_blank" disabled>
            <i class="bi bi-printer me-1"></i> Cetak PDF (Yang Dipilih)
        </button>
    @endif
@endsection

@section('content')
    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    {{-- ===== Switch Tab ala SOP (dua tombol sederhana) ===== --}}
    <div class="mb-3 d-flex align-items-center gap-2">
        <a href="{{ route($ns . '.sk.index', ['tab' => 'data'] + request()->except('page')) }}"
            class="btn {{ ($activeTab ?? 'data') === 'data' ? 'btn-primary' : 'btn-outline-primary' }}">
            Data SK
        </a>
        <a href="{{ route($ns . '.sk.index', ['tab' => 'rekap', 'year' => $year] + request()->except('page')) }}"
            class="btn {{ ($activeTab ?? 'data') === 'rekap' ? 'btn-primary' : 'btn-outline-primary' }}">
            Rekap SK
        </a>
    </div>

    {{-- ========================= TAB: DATA (gaya SOP) ========================= --}}
    <div class="{{ ($activeTab ?? 'data') === 'data' ? '' : 'd-none' }}">
        <div class="card shadow-sm">
            {{-- Toolbar / Filter ala SOP --}}
            <div class="card-body pb-2">
                <form method="get" class="row g-2 align-items-center">
                    {{-- jaga tab & filter lain --}}
                    <input type="hidden" name="tab" value="data">

                    <div class="col-lg-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ $q }}" class="form-control"
                                placeholder="Cari nomor / judul SK…">
                        </div>
                    </div>

                    @if ($isAdmin)
                        <div class="col-lg-3">
                            <select name="owner_role" class="form-select">
                                <option value="">— Semua Role —</option>
                                @foreach ($allRoles ?? [] as $r)
                                    <option value="{{ $r }}" @selected($ownerRole === $r)>{{ $r }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-lg-2 d-grid d-md-block">
                        <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button>
                        @if ($q || $ownerRole)
                            <a href="{{ route($ns . '.sk.index', ['tab' => 'data']) }}"
                                class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Tabel ala SOP --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width:72px" class="text-center">#</th>
                            <th style="width:160px">No SK</th>
                            <th>Judul SK</th>
                            @if ($isAdmin)
                                <th style="width:200px">Pembuat</th>
                            @endif
                            <th style="width:200px" class="text-center">Masa Berlaku</th>
                            <th style="width:120px" class="text-center">Status</th>
                            <th style="width:140px" class="text-center">Tanggal SK</th>
                            <th style="width:120px" class="text-center">PDF</th>
                            <th style="width:290px" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($list as $i => $sk)
                            <tr>
                                <td class="text-center">{{ $list->firstItem() + $i }}</td>
                                <td class="fw-semibold">{{ $sk->no_sk }}</td>
                                <td>{{ $sk->judul_sk }}</td>

                                @if ($isAdmin)
                                    @php
                                        $roleName = optional($sk->creator?->roles->first())->name;
                                        $creator = $sk->creator?->name;
                                    @endphp
                                    <td>
                                        @if ($roleName)
                                            <span class="badge text-bg-info">{{ $roleName }}</span>
                                        @endif
                                        <small class="text-muted ms-1">{{ $creator ?? '—' }}</small>
                                    </td>
                                @endif

                                <td class="text-center text-nowrap">
                                    {{ $sk->start_at?->format('d/m/Y') }} — {{ $sk->end_at?->format('d/m/Y') }}
                                </td>

                                @php $expired = $sk->end_at && now()->gt($sk->end_at); @endphp
                                <td class="text-center">
                                    <span class="badge {{ $expired ? 'text-bg-secondary' : 'text-bg-success' }}">
                                        {{ $expired ? 'Tidak Aktif' : 'Aktif' }}
                                    </span>
                                </td>

                                <td class="text-center">{{ $sk->tanggal_sk->format('d/m/Y') }}</td>

                                <td class="text-center">
                                    @if ($sk->pdf_path)
                                        <a href="{{ route($ns . '.sk.download', $sk) }}" target="_blank"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <a href="{{ route($ns . '.sk.edit', $sk) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route($ns . '.sk.destroy', $sk) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus SK ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 9 : 8 }}" class="text-center text-muted py-4">Belum ada data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer ala SOP (info & pagination) --}}
            <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small class="text-muted mb-2 mb-md-0">
                    Menampilkan {{ $list->count() ? $list->firstItem() . '–' . $list->lastItem() : 0 }} dari
                    {{ $totalData }} data
                </small>
                {{ $list->withQueryString()->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    {{-- ========================= TAB: REKAP (gaya SOP) ========================= --}}
    <div class="{{ ($activeTab ?? 'data') === 'rekap' ? '' : 'd-none' }}">
        <div class="card shadow-sm">

            {{-- Toolbar Rekap --}}
            <div class="card-body pb-2">
                <form id="form-selected" method="GET" action="{{ route($ns . '.sk.rekap.pdf', ['year' => $year]) }}"
                    target="_blank" class="row g-2 align-items-center">

                    {{-- Tahun --}}
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-calendar4"></i></span>
                            <select name="year" class="form-select"
                                onchange="
                      this.form.action = '{{ route($ns . '.sk.rekap.pdf', ['year' => '__YEAR__']) }}'
                        .replace('__YEAR__', this.value);
                    ">
                                @for ($y = now()->year + 1; $y >= now()->year - 6; $y--)
                                    <option value="{{ $y }}" @selected($y == $year)>{{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- (Admin) Filter Role --}}
                    @if ($isAdmin)
                        <div class="col-lg-3">
                            <select name="owner_role" class="form-select"
                                onchange="location.href='{{ route($ns . '.sk.index') }}?tab=rekap&year={{ $year }}&owner_role=' + this.value">
                                <option value="">— Semua Role —</option>
                                @foreach ($allRoles ?? [] as $r)
                                    <option value="{{ $r }}" @selected(request('owner_role') === $r)>{{ $r }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-lg-6 d-grid d-md-flex justify-content-md-end align-items-center">
                        <div class="form-check me-md-3 mb-2 mb-md-0">
                            <input type="checkbox" class="form-check-input" id="check-all">
                            <label for="check-all" class="form-check-label">Pilih semua</label>
                        </div>
                        <button type="submit" class="btn btn-outline-secondary" id="top-print-selected" disabled>
                            <i class="bi bi-printer me-1"></i> Cetak PDF (Yang Dipilih)
                        </button>
                    </div>
                </form>
            </div>

            {{-- … (tabel rekap & footer tetap seperti sebelumnya) --}}
        </div>
    </div>

@endsection
