<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'ym', // 'YYYY-MM'
    'rows' => [], // koleksi item bulan tsb
    'sum' => [], // summary bulan: sum_jumlah, sum_keluar, sum_sisa
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'ym', // 'YYYY-MM'
    'rows' => [], // koleksi item bulan tsb
    'sum' => [], // summary bulan: sum_jumlah, sum_keluar, sum_sisa
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $bulan = \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y');
?>

<h5 class="fw-bold mt-4 mb-2"><?php echo e($bulan); ?></h5>
<div class="table-card overflow-x-auto mb-4">
    <table class="bpbd-table min-w-full">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Harga Sat</th>
                <th>Jumlah Harga</th>
                <th>Keluar</th>
                <th>Harga Keluar</th>
                <th>Sisa Barang</th>
                <th>Sisa Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <input type="checkbox" name="selected_ids[]" value="<?php echo e($it->id); ?>" class="row-check"
                            data-month="<?php echo e($ym); ?>">
                    </td>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($it->tanggal->format('d/m/Y')); ?></td>
                    <td><?php echo e($it->nama_barang); ?></td>
                    <td><?php echo e(number_format($it->volume, 0, ',', '.')); ?></td>
                    <td><?php echo e($it->satuan); ?></td>
                    <td>Rp <?php echo e(number_format($it->harga_satuan, 0, ',', '.')); ?></td>
                    <td>Rp <?php echo e(number_format($it->jumlah_harga, 0, ',', '.')); ?></td>
                    <td><?php echo e(number_format($it->jumlah_keluar, 0, ',', '.')); ?></td>
                    <td>Rp <?php echo e(number_format($it->jumlah_harga_keluar, 0, ',', '.')); ?></td>
                    <td><?php echo e(number_format($it->sisa_barang, 0, ',', '.')); ?></td>
                    <td>Rp <?php echo e(number_format($it->sisa_harga, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr style="background:#fff7b5;font-weight:bold;">
                <td></td>
                <td colspan="6" class="text-end">Jumlah Bulan Ini</td>
                <td>Rp <?php echo e(number_format($sum['sum_jumlah'] ?? 0, 0, ',', '.')); ?></td>
                <td></td>
                <td>Rp <?php echo e(number_format($sum['sum_keluar'] ?? 0, 0, ',', '.')); ?></td>
                <td></td>
                <td>Rp <?php echo e(number_format($sum['sum_sisa'] ?? 0, 0, ',', '.')); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/logistik/month-table.blade.php ENDPATH**/ ?>