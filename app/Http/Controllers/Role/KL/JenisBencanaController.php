<?php

namespace App\Http\Controllers\Role\KL;

use App\Models\JenisBencana;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisBencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisBencanas = JenisBencana::orderBy('nama')->get();
        return view('role.kl.jenis-bencana.index', compact('jenisBencanas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.kl.jenis-bencana.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'ikon' => 'nullable|string|max:255',
        ]);

        JenisBencana::create($data);

        return redirect()->route('kl.jenis-bencana.index')->with('success', 'Jenis bencana berhasil ditambahkan.');
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
    public function edit(JenisBencana $jenisBencana)
    {
        return view('role.kl.jenis-bencana.edit', compact('jenisBencana'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisBencana $jenisBencana)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'ikon' => 'nullable|string|max:255',
        ]);

        $jenisBencana->update($data);

        return redirect()->route('kl.jenis-bencana.index')->with('success', 'Jenis bencana berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisBencana $jenisBencana)
    {
        $jenisBencana->delete();

        return redirect()->route('kl.jenis-bencana.index')->with('success', 'Jenis bencana berhasil dihapus.');
    }
}
