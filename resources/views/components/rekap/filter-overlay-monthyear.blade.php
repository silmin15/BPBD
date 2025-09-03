@props([
    'activeRole',
    // route submit ke index role aktif
    'submitRoute' => route('admin.rekap-kegiatan.rekap.role.index', $activeRole),
])

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="filterRekapTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="filterRekapTitle" class="m-0">
                <i class="bi bi-funnel"></i> Filter Rekap Laporan
            </h5>
            <button type="button" class="btn-close" id="close-filter" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="{{ $submitRoute }}" id="filter-form">
            <div class="row g-2">
                <div class="col-sm-6">
                    <label class="form-label">Bulan</label>
                    <input type="number" min="1" max="12" name="month" class="form-control"
                        value="{{ request('month') }}">
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Tahun</label>
                    <input type="number" min="2000" max="2100" name="year" class="form-control"
                        value="{{ request('year') ?: now()->year }}">
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ $submitRoute }}" class="btn btn-light">Reset</a>
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2" id="cancel-filter">Batal</button>
                    <button class="btn btn-primary">Terapkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
