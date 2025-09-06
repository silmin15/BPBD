<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan {{ $ctx }} #{{ $report->id }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 10px; text-transform: uppercase; }
    table.meta { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
    table.meta td { padding: 4px 6px; vertical-align: top; }
    .label { width: 180px; font-weight: bold; text-transform: uppercase; }
    .box { border:1px solid #999; padding:10px; margin-top:8px; }
    .photos img { height: 100px; margin: 4px; border: 1px solid #ccc; }
    .muted { color:#666; }
  </style>
</head>
<body>
  <h1>LAPORAN KEGIATAN ({{ $ctx }})</h1>

  <table class="meta">
    <tr>
      <td class="label">LAPORAN KEGIATAN</td>
      <td>: {{ $report->judul_laporan ?: '—' }}</td>
    </tr>
    <tr>
      <td class="label">KEPADA</td>
      <td>: {{ $report->kepada_yth ?: '—' }}</td>
    </tr>
    <tr>
      <td class="label">JENIS KEGIATAN</td>
      <td>: {{ $report->jenis_kegiatan ?: '—' }}</td>
    </tr>
    <tr>
      <td class="label">WAKTU KEGIATAN</td>
      <td>
        <div>Hari&nbsp;&nbsp;: {{ $report->hari ?: '—' }}</div>
        <div>Tgl&nbsp;&nbsp;&nbsp;: {{ optional($report->tanggal)->format('d/m/Y') ?: '—' }}</div>
        <div>Pukul : {{ $report->pukul ?: '—' }}</div>
      </td>
    </tr>
    <tr>
      <td class="label">LOKASI KEGIATAN</td>
      <td>: {{ $report->lokasi_kegiatan ?: '—' }}</td>
    </tr>
    <tr>
      <td class="label">PETUGAS</td>
      <td>: {{ $report->petugas ?: '—' }}</td>
    </tr>
    <tr>
      <td class="label muted">DIBUAT</td>
      <td class="muted">: {{ $report->author?->name ?? '—' }} • {{ $report->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
    </tr>
  </table>

  <div class="box">
    <strong>HASIL KEGIATAN</strong><br>
    {!! $report->hasil_kegiatan ? nl2br(e($report->hasil_kegiatan)) : '—' !!}
  </div>

  <div class="box">
    <strong>UNSUR YANG TERLIBAT</strong><br>
    {!! $report->unsur_yang_terlibat ? nl2br(e($report->unsur_yang_terlibat)) : '—' !!}
  </div>

  @if(!empty($report->dokumentasi))
    <div class="box">
      <strong>DOKUMENTASI</strong><br>
      <div class="photos">
        @foreach($report->dokumentasi as $p)
          {{-- DomPDF butuh path absolut; public_path ke storage symlink --}}
          <img src="{{ public_path('storage/'.$p) }}">
        @endforeach
      </div>
    </div>
  @else
    <div class="box">
      <strong>DOKUMENTASI</strong><br> —
    </div>
  @endif
</body>
</html>
