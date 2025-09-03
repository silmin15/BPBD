@props([
    'submitRoute' => '#',
])

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="lkFilterTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="lkFilterTitle" class="m-0">
                <i class="bi bi-funnel"></i> Filter Laporan Kegiatan
            </h5>
            <button type="button" class="btn-close" id="close-filter" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="{{ $submitRoute }}" id="filter-form">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jenis kegiatan</label>
                    <input type="text" name="jenis" class="form-control" placeholder="Contoh: evakuasi"
                        value="{{ request('jenis') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Dusun / Desa / Kec."
                        value="{{ request('lokasi') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Petugas</label>
                    <input type="text" name="petugas" class="form-control" placeholder="Nama petugas"
                        value="{{ request('petugas') }}">
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
