<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rekap Bulanan {{ $monthLabel }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 10px; }
    h2 { font-size: 14px; margin: 14px 0 6px; }
    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #999; padding:6px; vertical-align: top; }
    .muted { color:#666; }
  </style>
</head>
<body>
  <h1>Rekap Bulanan ({{ $monthLabel }})</h1>
  <div class="muted">Periode: {{ $start->format('d/m/Y') }} – {{ $end->format('d/m/Y') }}</div>

  @foreach (['PK' => $pk, 'KL' => $kl, 'RR' => $rr] as $role => $items)
    <h2>Bidang {{ $role }}</h2>
    <table>
      <thead>
        <tr>
          <th style="width:5%">#</th>
          <th>Judul</th>
          <th>Tanggal</th>
          <th>Lokasi</th>
          <th>Petugas</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $i => $r)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $r->judul_laporan }}</td>
            <td>{{ optional($r->tanggal)->format('d/m/Y') }}</td>
            <td>{{ $r->lokasi_kegiatan }}</td>
            <td>{{ $r->petugas }}</td>
          </tr>
        @empty
          <tr><td colspan="5" style="text-align:center">Tidak ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  @endforeach
</body>
</html>
