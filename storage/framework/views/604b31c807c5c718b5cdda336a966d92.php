
<?php
    $kecamatan = config('banjarnegara.kecamatan'); // 20 kec
?>

<div class="modal fade" id="bastModal" tabindex="-1" aria-labelledby="bastModalLabel"
    aria-hidden="true"data-desa-url="<?php echo e(route('geo.banjarnegara.desa')); ?>">>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="bastModalLabel">Pengajuan BAST (Berita Acara Serah Terima)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form method="POST" action="<?php echo e(route('bast.publik.store')); ?>" enctype="multipart/form-data" id="formBAST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">

                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Perwakilan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perwakilan" class="form-control" required>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Kecamatan (Kab. Banjarnegara) <span
                                class="text-danger">*</span></label>
                        <input type="text" name="kecamatan" class="form-control" list="listKecamatan"
                            placeholder="Contoh: Bawang" id="inputKecamatan" required>
                        <datalist id="listKecamatan">
                            <?php $__currentLoopData = $kecamatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k); ?>"><?php echo e($k); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>
                        <div class="form-text">Kamu boleh ketik bebas, daftar di atas untuk mempermudah.</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Desa/Kelurahan <span class="text-danger">*</span></label>
                        <input type="text" name="desa" class="form-control" list="listDesa" id="inputDesa"
                            placeholder="Pilih/ketik desa sesuai kecamatan" required>
                        <datalist id="listDesa"></datalist>
                        <div class="form-text">Daftar desa akan muncul otomatis setelah kamu pilih kecamatan.</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Unggah Surat Permohonan <span
                                class="text-danger">*</span></label>
                        <input type="file" name="surat_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png"
                            required>
                        <div class="form-text">Nama alat & spesifikasi cukup di dalam surat (tidak perlu di form).</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Catatan (opsional)</label>
                        <textarea name="catatan" rows="3" class="form-control" placeholder="Tambahan informasi bila perlu"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/pages/publik/bast-modal.blade.php ENDPATH**/ ?>