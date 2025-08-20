<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisWebController extends Controller
{
    public function index()
    {
        $items = Inventaris::all();
        return view('pages.inventaris.index', ['items' => $items]);
    }

    public function show($id)
    {
        $item = Inventaris::findOrFail($id);
        return view('pages.inventaris.show', ['items' => $item]);
    }
}
