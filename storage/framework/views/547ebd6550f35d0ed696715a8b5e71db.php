<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>BAST #<?php echo e($bast->id); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --text: #111827;
            --muted: #6b7280;
        }

        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Noto Sans', sans-serif;
            color: var(--text);
            margin: 24px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .header img {
            height: 64px;
        }

        h1 {
            font-size: 20px;
            margin: 0;
        }

        .meta {
            font-size: 12px;
            color: var(--muted);
        }

        .box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-top: 12px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .col {
            flex: 1 1 280px;
        }

        .label {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .val {
            font-weight: 600;
        }

        hr {
            border: 0;
            border-top: 1px solid #e5e7eb;
            margin: 16px 0;
        }

        .ttd {
            display: flex;
            justify-content: space-between;
            margin-top: 32px;
            gap: 24px;
        }

        .ttd .slot {
            flex: 1 1 45%;
            text-align: center;
        }

        .small {
            font-size: 12px;
            color: var(--muted);
        }

        @media print {
            @page {
                margin: 16mm;
            }

            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom:12px">
        <button onclick="window.print()">Cetak</button>
    </div>

    <div class="header">
        <img src="<?php echo e(public_path('images/logo-bpbd.png')); ?>" alt="BPBD">
        <div>
            <h1>BERITA ACARA SERAH TERIMA (BAST)</h1>
            <div class="meta">Nomor: #<?php echo e($bast->id); ?> • Tanggal:
                <?php echo e($bast->approved_at?->format('d/m/Y') ?? now()->format('d/m/Y')); ?></div>
        </div>
    </div>

    <div class="box">
        <div class="row">
            <div class="col">
                <div class="label">Nama Perwakilan</div>
                <div class="val"><?php echo e($bast->nama_perwakilan); ?></div>
            </div>
            <div class="col">
                <div class="label">Kecamatan</div>
                <div class="val"><?php echo e($bast->kecamatan); ?></div>
            </div>
            <div class="col">
                <div class="label">Desa/Kelurahan</div>
                <div class="val"><?php echo e($bast->desa); ?></div>
            </div>
            <div class="col">
                <div class="label">Alamat</div>
                <div class="val"><?php echo e($bast->alamat ?: '—'); ?></div>
            </div>
        </div>

        <hr>

        <div class="label">Catatan</div>
        <div><?php echo e($bast->catatan ?: '—'); ?></div>

        <hr>

        <div class="small">
            Surat permohonan terlampir:
            <?php if($bast->surat_path): ?>
                tersedia pada arsip internal (path: <?php echo e($bast->surat_path); ?>).
            <?php else: ?>
                — tidak ada file —
            <?php endif; ?>
        </div>
    </div>

    <div class="ttd">
        <div class="slot">
            <div>Yang Menyerahkan</div>
            <div style="height:72px"></div>
            <div>(................................................)</div>
        </div>
        <div class="slot">
            <div>Yang Menerima</div>
            <div style="height:72px"></div>
            <div>(................................................)</div>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\laragon\www\BPBD\resources\views/role/pk/bast/print.blade.php ENDPATH**/ ?>