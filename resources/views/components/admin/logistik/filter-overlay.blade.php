@props([
    'year',
    'filters' => [],
    'klList' => collect(),
    'submitRoute',
    'pdfRoute',
    'openBtnId' => 'open-filter',
    'closeBtnId' => 'close-filter',
])

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="filterTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="filterTitle" class="m-0"><i class="bi bi-funnel"></i> Filter Rekap Logistik</h5>
            <button type="button" class="btn-close" id="{{ $closeBtnId }}" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="{{ $submitRoute }}" id="filter-form">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ $filters['start'] ?? ($filters['start_date'] ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ $filters['end'] ?? ($filters['end_date'] ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bulan dari</label>
                    <input type="number" min="1" max="12" name="month_from" class="form-control"
                        value="{{ request('month_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bulan sampai</label>
                    <input type="number" min="1" max="12" name="month_to" class="form-control"
                        value="{{ request('month_to') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Stok</label>
                    <select name="stok" class="form-select">
                        <option value="">— Semua —</option>
                        <option value="ada" @selected(request('stok') === 'ada')>Masih ada</option>
                        <option value="habis"@selected(request('stok') === 'habis')>Habis</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">KL (Penginput)</label>
                    <select name="kl_id" class="form-select">
                        <option value="">— Semua —</option>
                        @foreach ($klList as $kl)
                            <option value="{{ $kl->id }}" @selected(request('kl_id') == $kl->id)>{{ $kl->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kata kunci</label>
                    <input type="text" name="q" class="form-control" placeholder="Nama barang / satuan"
                        value="{{ request('q') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Urutkan</label>
                    <select name="sort" class="form-select">
                        <option value="tanggal_asc" @selected(request('sort') === 'tanggal_asc')>Tanggal ↑</option>
                        <option value="tanggal_desc" @selected(request('sort') === 'tanggal_desc')>Tanggal ↓</option>
                        <option value="nama_asc" @selected(request('sort') === 'nama_asc')>Nama A→Z</option>
                        <option value="nama_desc" @selected(request('sort') === 'nama_desc')>Nama Z→A</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ $submitRoute }}" class="btn btn-light">Reset</a>
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2" id="cancel-filter">Batal</button>
                    <button class="btn btn-primary">Terapkan Filter</button>
                    <button type="button" class="btn btn-success ms-2" id="apply-print"
                        data-pdf-url="{{ $pdfRoute }}">
                        <i class="bi bi-printer"></i> Terapkan & Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
