<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanApiController extends Controller
{
    /**
     * Get kecamatan boundaries as GeoJSON
     */
    public function boundaries()
    {
        try {
            // Sample data untuk demo - dalam implementasi nyata, ini akan dari database
            $kecamatanData = [
                [
                    'id' => 1,
                    'nama' => 'Banjarnegara',
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [[
                            [109.5, -7.3],
                            [109.6, -7.3],
                            [109.6, -7.4],
                            [109.5, -7.4],
                            [109.5, -7.3]
                        ]]
                    ]
                ],
                [
                    'id' => 2,
                    'nama' => 'Punggelan',
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [[
                            [109.4, -7.2],
                            [109.5, -7.2],
                            [109.5, -7.3],
                            [109.4, -7.3],
                            [109.4, -7.2]
                        ]]
                    ]
                ],
                [
                    'id' => 3,
                    'nama' => 'Purwanegara',
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [[
                            [109.6, -7.2],
                            [109.7, -7.2],
                            [109.7, -7.3],
                            [109.6, -7.3],
                            [109.6, -7.2]
                        ]]
                    ]
                ]
            ];

            $features = [];
            foreach ($kecamatanData as $kec) {
                $features[] = [
                    'type' => 'Feature',
                    'properties' => [
                        'id' => $kec['id'],
                        'nama' => $kec['nama'],
                        'fillColor' => '#3b82f6',
                        'fillOpacity' => 0.1,
                        'strokeColor' => '#1e40af',
                        'strokeWeight' => 2
                    ],
                    'geometry' => $kec['geometry']
                ];
            }

            $geojson = [
                'type' => 'FeatureCollection',
                'features' => $features
            ];

            return response()->json([
                'status' => 'success',
                'data' => $geojson
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data batas kecamatan'
            ], 500);
        }
    }

    /**
     * Get kecamatan statistics
     */
    public function statistics()
    {
        try {
            // Hitung statistik bencana per kecamatan
            $stats = DB::table('kejadian_bencanas')
                ->join('jenis_bencanas', 'kejadian_bencanas.jenis_bencana_id', '=', 'jenis_bencanas.id')
                ->select(
                    'kejadian_bencanas.kecamatan',
                    DB::raw('COUNT(*) as total_kejadian'),
                    DB::raw('COUNT(DISTINCT jenis_bencanas.id) as jenis_bencana_unik')
                )
                ->groupBy('kejadian_bencanas.kecamatan')
                ->orderBy('total_kejadian', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil statistik kecamatan'
            ], 500);
        }
    }
}

