@props([
    'submitRoute' => route('kl.logistik.index'),
])

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="filterKlTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="filterKlTitle" class="m-0">
                <i class="bi bi-funnel"></i> Filter Laporan KL
            </h5>
            <button type="button" class="btn-close" id="close-filter" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="{{ $submitRoute }}" id="filter-form">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Nama barang / satuan</label>
                    <input type="text" name="q" class="form-control" placeholder="Contoh: beras / dus"
                        value="{{ request('q') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bulan (opsional)</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
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
