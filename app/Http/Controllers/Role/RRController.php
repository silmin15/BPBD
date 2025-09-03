<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;

class RRController extends Controller
{
    public function index()
    {
        return view('role.rr.dashboard');
    }
}