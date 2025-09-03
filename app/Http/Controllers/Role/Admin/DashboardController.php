<?php

namespace App\Http\Controllers\Role\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // pastikan view ini ada (lihat langkah B)
        return view('role.admin.dashboard');
    }
}
