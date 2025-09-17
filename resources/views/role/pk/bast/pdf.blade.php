<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>BAST #{{ $bast->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 18mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Times New Roman", Times, serif;
            color: #000;
        }

        .kop {
            text-align: center;
            line-height: 1.25;
            margin-bottom: 8mm;
        }

        .kop .instansi {
            font-weight: 700;
            font-size: 14pt;
        }

        .kop .alamat {
            font-size: 9pt;
        }

        .judul {
            text-align: center;
            font-weight: 700;
            font-size: 12pt;
            text-decoration: underline;
            margin: 2mm 0 6mm;
        }

        .meta {
            width: 100%;
            font-size: 10pt;
            border-collapse: collapse;
            margin-bottom: 6mm;
        }

        .meta td {
            vertical-align: top;
            padding: 2px 0;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }

        .table th {
            text-align: center;
        }

        .footnote {
            font-size: 10pt;
            margin-top: 6mm;
        }

        /* Tanda tangan pakai tabel agar stabil di DomPDF */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16mm;
        }

        .sign-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 6mm;
        }

        .sign-space {
            height: 24mm;
        }

        /* ruang tanda tangan/stempel */
        .u {
            text-decoration: underline;
            font-weight: 700;
        }

        .muted {
            font-size: 9pt;
            margin-top: 2mm;
            color: #444;
        }

        /* Hindari area tanda tangan kepecah di akhir halaman */
        .sign-table tr,
        .sign-table td {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="instansi">PEMERINTAH KABUPATEN BANJARNEGARA</div>
        <div class="instansi">BADAN PENANGGULANGAN BENCANA DAERAH</div>
        <div class="alamat">Jl. Selamanik No. 29 Telp. (0286) 591612 | banjarnegarakab.go.id</div>
        <div class="alamat">BANJARNEGARA 53415</div>
    </div>

    <div class="judul">TANDA TERIMA BARANG</div>

    {{-- IDENTITAS PIHAK --}}
    <table class="meta">
        <tr>
            <td width="4%">1</td>
            <td width="25%">Nama</td>
            <td width="2%">:</td>
            <td>TURSIMAN, S.Sos</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP</td>
            <td>:</td>
            <td>19640825 198405 1 007</td>
        </tr>
        <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td>Kepala Pelaksana BPBD Kabupaten Banjarnegara</td>
        </tr>
        <tr>
            <td colspan="4">Selanjutnya disebut <strong>PIHAK PERTAMA</strong></td>
        </tr>

        <tr>
            <td style="height:3mm"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>2</td>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $bast->nama_perwakilan }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Alamat/Desa</td>
            <td>:</td>
            <td>{{ $bast->desa }}, Kec. {{ $bast->kecamatan }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td>Perwakilan Penerima</td>
        </tr>
        <tr>
            <td colspan="4">Selanjutnya disebut <strong>PIHAK KEDUA</strong></td>
        </tr>
    </table>

    <p class="footnote">
        Dengan ini <strong>PIHAK PERTAMA</strong> menyerahkan kepada <strong>PIHAK KEDUA</strong> berupa peralatan
        kesiapsiagaan bencana dengan rincian sebagai berikut:
    </p>

    {{-- TABEL BARANG --}}
    <table class="table">
        <thead>
            <tr>
                <th style="width:28px">No</th>
                <th>Nama Barang</th>
                <th style="width:80px">Sumber</th>
                <th style="width:65px">Jumlah</th>
                <th style="width:65px">Satuan</th>
                <th style="width:95px">Harga Satuan</th>
                <th style="width:105px">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            {{-- Contoh baris. Jika ada data detail, loop di sini. --}}
            <tr>
                <td align="center">1</td>
                <td>Handy Talky (HT)</td>
                <td align="center">APBD</td>
                <td align="center">4</td>
                <td align="center">Buah</td>
                <td align="right">1.541.000</td>
                <td align="right">6.164.000</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td>Gergaji Mesin</td>
                <td align="center">APBD</td>
                <td align="center">1</td>
                <td align="center">Buah</td>
                <td align="right">9.500.000</td>
                <td align="right">9.500.000</td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>Jumlah</strong></td>
                <td align="right"><strong>15.664.000</strong></td>
            </tr>
        </tbody>
    </table>

    <p class="footnote">
        Demikian Berita Acara ini dibuat dengan sebenarnya dalam rangkap dua untuk dipergunakan sebagaimana mestinya.
    </p>

    {{-- TANDA TANGAN (sejajar) --}}
    <table class="sign-table">
        <tr>
            <td>
                <div><strong>PIHAK KEDUA</strong></div>
                <div class="sign-space"></div>
                <div class="u">{{ strtoupper($bast->nama_perwakilan) }}</div>
            </td>
            <td>
                <div><strong>PIHAK PERTAMA</strong></div>
                <div class="muted">Kepala Pelaksana BPBD Kab. Banjarnegara</div>
                <div class="sign-space"></div>
                <div class="u">TURSIMAN, S.Sos</div>
                <div class="muted">NIP. 19640825 198803 1 004</div>
            </td>
        </tr>
    </table>

</body>

</html>
