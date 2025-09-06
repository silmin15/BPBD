<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba autentikasi user
        if (! Auth::attempt($request->only('email', 'password'))) {
            // Jika gagal, lempar error validasi dengan pesan kustom
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
            ]);
        }

        // 3. Jika berhasil, dapatkan data user
        $user = Auth::user();

        // 4. Tentukan tujuan redirect berdasarkan role
        $redirectUrl = '/dashboard'; // default
        if (($user->role ?? null) === 'Staf BPBD') {   // sesuaikan nama kolomnya
            $redirectUrl = '/inventaris';
        }

        // 5. Kirim respons JSON yang SUKSES
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil!',
            'redirect_url' => $redirectUrl, // Kirim URL tujuan ke frontend
        ]);
    }
}
