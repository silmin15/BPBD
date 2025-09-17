<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // TODO: ganti query di bawah sesuai skema datamu
        // Sementara default 0 agar aman
        $stats = [
            'bencana'    => 0,
            'meninggal'  => 0,
            'hilang'     => 0,
            'luka'       => 0,
            'mengungsi'  => 0,
            'menderita'  => 0,
        ];

        // Contoh bila sudah ada model:
        // $stats['bencana']   = \App\Models\Kejadian::count();
        // $stats['meninggal'] = \App\Models\Korban::where('status','meninggal')->sum('jumlah');
        // dst…

        // Berita/sosialisasi terbaru (ganti sesuai modelmu)
        $news = collect([
            // Contoh dummy (hapus saat sudah ada model)
            ['title' => 'Sosialisasi Desa Tangguh Bencana', 'date' => now(), 'thumb' => asset('images/news-1.jpg'), 'url' => '#'],
            ['title' => 'Pelatihan Mitigasi Longsor',       'date' => now()->subDays(2), 'thumb' => asset('images/news-2.jpg'), 'url' => '#'],
            ['title' => 'Simulasi Kebencanaan Sekolah',     'date' => now()->subWeek(), 'thumb' => asset('images/news-3.jpg'), 'url' => '#'],
        ]);

        return view('pages.publik.home', compact('stats', 'news'));
    }
}
