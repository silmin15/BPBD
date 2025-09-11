<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KejadianBencana;
use App\Models\JenisBencana;
use Illuminate\Http\Request;

class KejadianBencanaApiController extends Controller
{
    /**
     * Get all kejadian bencana data for map
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = KejadianBencana::with('jenisBencana');

        // Pencarian bebas (judul, alamat, kecamatan)
        if ($request->filled('q')) {
            $driver = config('database.default');
            $like = $driver === 'pgsql' ? 'ilike' : 'like';
            $s = $request->input('q');
            $query->where(function ($w) use ($s, $like) {
                $w->where('judul_kejadian', $like, "%{$s}%")
                    ->orWhere('alamat_lengkap', $like, "%{$s}%")
                    ->orWhere('kecamatan', $like, "%{$s}%");
            });
        }

        // Filter by jenis bencana
        if ($request->has('jenis_bencana_id')) {
            $query->where('jenis_bencana_id', $request->jenis_bencana_id);
        }

        // Filter by kecamatan
        if ($request->has('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_kejadian', [$request->start_date, $request->end_date]);
        } elseif ($request->has('start_date')) {
            $query->whereDate('tanggal_kejadian', '>=', $request->start_date);
        } elseif ($request->has('end_date')) {
            $query->whereDate('tanggal_kejadian', '<=', $request->end_date);
        }

        // Spatial filters (PostGIS)
        if (config('database.default') === 'pgsql') {
            if ($bbox = $request->get('bbox')) { // minLng,minLat,maxLng,maxLat
                $parts = array_map('trim', explode(',', $bbox));
                if (count($parts) === 4) {
                    [$minLng, $minLat, $maxLng, $maxLat] = array_map('floatval', $parts);
                    $wkt = sprintf('POLYGON((%f %f,%f %f,%f %f,%f %f,%f %f))',
                        $minLng, $minLat, $maxLng, $minLat, $maxLng, $maxLat, $minLng, $maxLat, $minLng, $minLat);
                    $query->whereRaw('geom && ST_GeomFromText(?, 4326)', [$wkt]);
                }
            }
            if ($circle = $request->get('circle')) { // lat,lng,meters
                $parts = array_map('trim', explode(',', $circle));
                if (count($parts) === 3) {
                    [$lat, $lng, $meters] = [floatval($parts[0]), floatval($parts[1]), floatval($parts[2])];
                    $query->whereRaw('ST_DWithin(geom::geography, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, ?)', [$lng, $lat, $meters]);
                }
            }
        }

        $kejadianBencanas = $query->orderByDesc('tanggal_kejadian')->get();

        $data = $kejadianBencanas->map(function ($kejadian) {
            return [
                'id' => $kejadian->id,
                'judul' => $kejadian->judul_kejadian,
                'jenis_bencana' => [
                    'id' => $kejadian->jenisBencana->id,
                    'nama' => $kejadian->jenisBencana->nama,
                    'ikon' => $kejadian->jenisBencana->ikon,
                ],
                'alamat' => $kejadian->alamat_lengkap,
                'kecamatan' => $kejadian->kecamatan,
                'latitude' => (float) $kejadian->latitude,
                'longitude' => (float) $kejadian->longitude,
                'tanggal' => $kejadian->tanggal_kejadian,
                'waktu' => $kejadian->waktu_kejadian,
                'keterangan' => $kejadian->keterangan,
                'geofile' => $kejadian->geofile_path ? [
                    'name' => $kejadian->geofile_name,
                    'url'  => \Storage::url($kejadian->geofile_path),
                ] : null,
                'geometry' => (config('database.default') === 'pgsql' && $kejadian->geom)
                    ? json_decode(\DB::selectOne('SELECT ST_AsGeoJSON(geom) as g FROM kejadian_bencanas WHERE id = ?', [$kejadian->id])->g, true)
                    : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    /**
     * Get all jenis bencana for filter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function jenisBencana()
    {
        $jenisBencanas = JenisBencana::orderBy('nama')->get();

        $data = $jenisBencanas->map(function ($jenis) {
            return [
                'id' => $jenis->id,
                'nama' => $jenis->nama,
                'ikon' => $jenis->ikon,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    /**
     * Get all kecamatan for filter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function kecamatan()
    {
        $kecamatans = KejadianBencana::select('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');

        return response()->json([
            'status' => 'success',
            'data' => $kecamatans,
        ]);
    }
}