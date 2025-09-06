<?php

namespace App\Http\Controllers\Role\KL;

use App\Http\Controllers\Controller;

class KLController extends Controller
{
    public function index()
    {
        return view('role.kl.dashboard');
    }
}
