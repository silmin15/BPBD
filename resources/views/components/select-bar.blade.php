{{-- resources/views/components/select-bar.blade.php --}}
<div class="d-flex align-items-center justify-content-between p-2 mb-2"
    style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;">
    <div class="d-flex align-items-center gap-3">
        <label class="d-inline-flex align-items-center gap-2">
            <input type="checkbox" id="check-all-global">
            <span>Pilih Semua (Semua Bulan)</span>
        </label>
        <span class="text-muted">Terpilih: <strong id="selected-count">0</strong></span>
    </div>
    <div class="small text-muted">Gunakan checkbox per-bulan di judul tabel untuk pilih cepat per-bulan.</div>
</div>
