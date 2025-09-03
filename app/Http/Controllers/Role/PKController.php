<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;

class PKController extends Controller
{
    public function index()
    {
        // data khusus PK bisa kamu kumpulkan di sini
        return view('role.pk.dashboard');
    }
}
