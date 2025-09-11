<?php

namespace App\Http\Controllers\Role\KL;

use App\Http\Controllers\Controller;
use App\Models\KejadianBencana;
use App\Models\JenisBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KejadianBencanaController extends Controller
{
    public function index(Request $r)
    {
        $q = KejadianBencana::with('jenisBencana');

        // deteksi driver untuk LIKE vs ILIKE
        $driver = config('database.default');
        $like = $driver === 'pgsql' ? 'ilike' : 'like';

        // Pencarian judul kejadian
        if ($s = $r->input('q')) {
            $q->where(function ($w) use ($s, $like) {
                $w->where('judul_kejadian', $like, "%{$s}%")
                    ->orWhere('alamat_lengkap', $like, "%{$s}%")
                    ->orWhere('kecamatan', $like, "%{$s}%");
            });
        }

        // Filter jenis bencana
        if ($jenis = $r->input('jenis_bencana_id')) {
            $q->where('jenis_bencana_id', $jenis);
        }

        // Filter kecamatan
        if ($kec = $r->input('kecamatan')) {
            $q->where('kecamatan', $kec);
        }

        // Filter rentang tanggal
        $start = $r->input('start_date');
        $end   = $r->input('end_date');
        if ($start && $end) {
            $q->whereBetween('tanggal_kejadian', [$start, $end]);
        } elseif ($start) {
            $q->whereDate('tanggal_kejadian', '>=', $start);
        } elseif ($end) {
            $q->whereDate('tanggal_kejadian', '<=', $end);
        }

        $kejadianBencanas = $q->orderByDesc('tanggal_kejadian')->paginate(15)->withQueryString();
        $jenisBencanas = JenisBencana::orderBy('nama')->get();

        // Ambil daftar kecamatan unik untuk filter
        $kecamatans = KejadianBencana::select('kecamatan')->distinct()->orderBy('kecamatan')->pluck('kecamatan');

        // VIEW sesuai struktur: resources/views/role/kl/kejadian-bencana/index.blade.php
        return view('role.kl.kejadian-bencana.index', compact('kejadianBencanas', 'jenisBencanas', 'kecamatans'));
    }

    public function create()
    {
        // Gate::authorize('kejadian-bencana.manage');
        $jenisBencanas = JenisBencana::orderBy('nama')->get();
        return view('role.kl.kejadian-bencana.create', compact('jenisBencanas'));
    }

    public function store(Request $r)
    {
        // Gate::authorize('kejadian-bencana.manage');

        $data = $r->validate([
            'judul_kejadian'   => ['required', 'string', 'max:255'],
            'jenis_bencana_id' => ['required', 'exists:jenis_bencanas,id'],
            'alamat_lengkap'   => ['required', 'string'],
            'kecamatan'        => ['required', 'string', 'max:100'],
            'latitude'         => ['required', 'numeric', 'between:-90,90'],
            'longitude'        => ['required', 'numeric', 'between:-180,180'],
            'tanggal_kejadian' => ['required', 'date'],
            'waktu_kejadian'   => ['required', 'date_format:H:i'],
            'keterangan'       => ['nullable', 'string'],
            'geofile'          => ['nullable', 'file', 'mimes:zip,kml,kmz,geojson,shp,rar', 'max:10240'],
        ]);

        if ($r->hasFile('geofile')) {
            $file = $r->file('geofile');
            $stored = $file->store('public/geodata');
            $data['geofile_path'] = $stored; // storage path
            $data['geofile_name'] = $file->getClientOriginalName();
        }

        $created = KejadianBencana::create($data);

        // Set geom for PostGIS
        if (config('database.default') === 'pgsql' && isset($data['latitude'], $data['longitude'])) {
            $lat = (float) $data['latitude'];
            $lng = (float) $data['longitude'];
            DB::statement(
                'UPDATE kejadian_bencanas SET geom = ST_SetSRID(ST_MakePoint(?, ?), 4326) WHERE id = ?',
                [$lng, $lat, $created->id]
            );
        }

        return redirect()->route('kl.kejadian-bencana.index')
            ->with('success', 'Data kejadian bencana berhasil ditambahkan');
    }

    public function edit(KejadianBencana $kejadianBencana)
    {
        // Gate::authorize('kejadian-bencana.manage');
        $jenisBencanas = JenisBencana::orderBy('nama')->get();
        return view('role.kl.kejadian-bencana.edit', compact('kejadianBencana', 'jenisBencanas'));
    }

    public function update(Request $r, KejadianBencana $kejadianBencana)
    {
        // Gate::authorize('kejadian-bencana.manage');

        $data = $r->validate([
            'judul_kejadian'   => ['required', 'string', 'max:255'],
            'jenis_bencana_id' => ['required', 'exists:jenis_bencanas,id'],
            'alamat_lengkap'   => ['required', 'string'],
            'kecamatan'        => ['required', 'string', 'max:100'],
            'latitude'         => ['required', 'numeric', 'between:-90,90'],
            'longitude'        => ['required', 'numeric', 'between:-180,180'],
            'tanggal_kejadian' => ['required', 'date'],
            'waktu_kejadian'   => ['required', 'date_format:H:i'],
            'keterangan'       => ['nullable', 'string'],
            'geofile'          => ['nullable', 'file', 'mimes:zip,kml,kmz,geojson,shp,rar', 'max:10240'],
        ]);

        if ($r->hasFile('geofile')) {
            $file = $r->file('geofile');
            $stored = $file->store('public/geodata');
            $data['geofile_path'] = $stored;
            $data['geofile_name'] = $file->getClientOriginalName();
        }

        $kejadianBencana->update($data);

        // Update geom for PostGIS
        if (config('database.default') === 'pgsql' && isset($data['latitude'], $data['longitude'])) {
            $lat = (float) $data['latitude'];
            $lng = (float) $data['longitude'];
            DB::statement(
                'UPDATE kejadian_bencanas SET geom = ST_SetSRID(ST_MakePoint(?, ?), 4326) WHERE id = ?',
                [$lng, $lat, $kejadianBencana->id]
            );
        }

        return redirect()->route('kl.kejadian-bencana.index')
            ->with('success', 'Data kejadian bencana berhasil diperbarui');
    }

    public function destroy(KejadianBencana $kejadianBencana)
    {
        // Gate::authorize('kejadian-bencana.manage');
        $kejadianBencana->delete();

        return redirect()->route('kl.kejadian-bencana.index')
            ->with('success', 'Data kejadian bencana berhasil dihapus');
    }

    public function show(KejadianBencana $kejadianBencana)
    {
        return view('role.kl.kejadian-bencana.show', compact('kejadianBencana'));
    }

    /**
     * Bulk import form (GeoJSON)
     */
    public function importForm()
    {
        $jenisBencanas = JenisBencana::orderBy('nama')->get();
        return view('role.kl.kejadian-bencana.import', compact('jenisBencanas'));
    }

    /**
     * Handle GeoJSON bulk import. Creates many KejadianBencana at once.
     */
    public function importStore(Request $r)
    {
        $payload = $r->validate([
            'file' => ['nullable', 'file', 'mimetypes:application/json,application/geo+json,text/plain,application/zip,application/x-zip-compressed', 'max:51200'],
            'geojson_text' => ['nullable', 'string'],
            'default_jenis_bencana_id' => ['nullable', 'exists:jenis_bencanas,id'],
            'date_field' => ['nullable', 'string'],
            'time_field' => ['nullable', 'string'],
            'title_field' => ['nullable', 'string'],
            'alamat_field' => ['nullable', 'string'],
            'kecamatan_field' => ['nullable', 'string'],
        ]);

        $jsonRaw = $payload['geojson_text'] ?? null;
        if (!$jsonRaw && $r->hasFile('file')) {
            $jsonRaw = file_get_contents($r->file('file')->getRealPath());
        }
        if (!$jsonRaw) {
            return back()->withErrors(['file' => 'Harap unggah GeoJSON atau hasil konversi dari ZIP Shapefile.']);
        }
        $json = json_decode($jsonRaw, true);
        if (!$json) {
            return back()->withErrors(['file' => 'File GeoJSON tidak valid.']);
        }

        $features = $json['features'] ?? [];
        if (!is_array($features) || count($features) === 0) {
            return back()->withErrors(['file' => 'GeoJSON tidak memiliki fitur.']);
        }

        $created = 0;
        DB::beginTransaction();
        try {
            foreach ($features as $feature) {
                $props = $feature['properties'] ?? [];
                $geom  = $feature['geometry'] ?? null;
                if (!$geom) continue;

                // Derive lat/lng from geometry (Point preferred, else centroid)
                [$lat, $lng] = $this->extractLatLng($geom);
                if ($lat === null || $lng === null) continue;

                $judul = $this->pickField($props, $payload['title_field'] ?? null, ['judul','title','name','nama','kejadian']);
                $alamat = $this->pickField($props, $payload['alamat_field'] ?? null, ['alamat','address','lokasi']);
                $kecamatan = $this->pickField($props, $payload['kecamatan_field'] ?? null, ['kecamatan','district','kec']);
                $tanggal = $this->pickField($props, $payload['date_field'] ?? null, ['tanggal','date','tgl']);
                $waktu = $this->pickField($props, $payload['time_field'] ?? null, ['waktu','time','jam']);

                // Fallbacks
                $judul = $judul ?: 'Kejadian Tanpa Judul';
                $tanggal = $tanggal ?: now()->format('Y-m-d');
                $waktu = $waktu ?: '12:00';

                // Jenis bencana: default dari form, atau coba cocokkan by name di props
                $jenisId = $payload['default_jenis_bencana_id'] ?? null;
                if (!$jenisId) {
                    $jenisName = $this->pickField($props, null, ['jenis','jenis_bencana','kategori','type']);
                    if ($jenisName) {
                        $match = JenisBencana::where('nama', 'like', $jenisName)->first();
                        if ($match) $jenisId = $match->id;
                    }
                }
                if (!$jenisId) continue; // lewati jika tidak jelas jenisnya

                $created = KejadianBencana::create([
                    'judul_kejadian' => $judul,
                    'jenis_bencana_id' => $jenisId,
                    'alamat_lengkap' => $alamat,
                    'kecamatan' => $kecamatan,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'tanggal_kejadian' => $tanggal,
                    'waktu_kejadian' => $waktu,
                    'keterangan' => null,
                ]);
                if (config('database.default') === 'pgsql') {
                    DB::statement('UPDATE kejadian_bencanas SET geom = ST_SetSRID(ST_MakePoint(?, ?), 4326) WHERE id = ?', [(float)$lng, (float)$lat, $created->id]);
                }
                $created++;
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Gagal impor: '.$e->getMessage()]);
        }

        return redirect()->route('kl.kejadian-bencana.index')
            ->with('success', "Impor selesai: {$created} data dibuat.");
    }

    private function pickField(array $props, ?string $preferred, array $candidates): ?string
    {
        if ($preferred && isset($props[$preferred])) return (string) $props[$preferred];
        foreach ($candidates as $key) {
            if (isset($props[$key])) return (string) $props[$key];
            // coba variasi case-insensitive
            foreach ($props as $k => $v) {
                if (strtolower($k) === strtolower($key)) return (string) $v;
            }
        }
        return null;
    }

    private function extractLatLng(array $geometry): array
    {
        $type = $geometry['type'] ?? null;
        $coords = $geometry['coordinates'] ?? null;
        if (!$type || !$coords) return [null, null];

        if ($type === 'Point' && is_array($coords) && count($coords) >= 2) {
            // GeoJSON: [lng, lat]
            return [ (float) $coords[1], (float) $coords[0] ];
        }

        // Centroid kasar untuk LineString / Polygon: ambil rata-rata
        $all = [];
        $flatten = function($arr) use (&$flatten, &$all) {
            foreach ($arr as $v) {
                if (is_array($v) && isset($v[0]) && is_numeric($v[0]) && isset($v[1]) && is_numeric($v[1])) {
                    $all[] = $v; // [lng, lat]
                } elseif (is_array($v)) {
                    $flatten($v);
                }
            }
        };
        $flatten($coords);
        if (count($all) > 0) {
            $sumLng = 0; $sumLat = 0; $n = count($all);
            foreach ($all as [$lng, $lat]) { $sumLng += $lng; $sumLat += $lat; }
            return [ (float) ($sumLat / $n), (float) ($sumLng / $n) ];
        }
        return [null, null];
    }
}