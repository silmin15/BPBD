<?php

namespace App\Http\Controllers;

use App\Models\JenisBencana;
use Illuminate\Http\Request;
use App\Models\KejadianBencana;

class KejadianBencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kejadians = KejadianBencana::with('jenisBencana')->latest()->get();
        return view('admin.kejadian.index', compact('kejadians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kejadians = JenisBencana::all();
        return view('admin.kejadian.create', compact('jenisBencanas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_kejadian' => 'required',
            'jenis_bencana_id' => 'required|exists:jenis_bencanas,id',
            'alamat_lengkap' => 'required',
            'kecamatan' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tanggal_kejadian' => 'required|date',
        ]);

        KejadianBencana::create($request->all());

        return redirect()->route('admin.kejadian.index')->with('success', 'Catatan kejadian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
