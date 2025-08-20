<?php

namespace App\Http\Controllers;

use App\Models\JenisBencana;
use Illuminate\Http\Request;

class JenisBencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisBencanas = JenisBencana::latest()->get();
        return view('admin.jenis_bencana.index', compact('jenisBencanas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jenis_bencana.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_bencanas',
        ]);

        JenisBencana::create($request->all());

        return redirect()->route('admin.jenis-bencana.index')->with('success', 'Jenis Bencana berhasil ditambahkan.');
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
