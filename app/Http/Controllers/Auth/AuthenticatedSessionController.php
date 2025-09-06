<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Tentukan URL home berdasarkan role (prioritas tegas).
     */
    private function homeFor($user): string
    {
        if ($user->hasRole('Super Admin')) return route('admin.dashboard');
        if ($user->hasRole('PK'))          return route('pk.dashboard');
        if ($user->hasRole('KL'))          return route('kl.dashboard');
        if ($user->hasRole('RR'))          return route('rr.dashboard');
        // if ($user->hasRole('Staf BPBD'))   return route('admin.inventaris.index');
        return route('dashboard'); // fallback jika belum punya role
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        // Auth & regenerate session
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();
        $to   = $this->homeFor($user);

        // Hindari "nyasar" karena intended URL lama
        $request->session()->forget('url.intended');

        // AJAX login (fetch) -> balas JSON konsisten
        if ($request->expectsJson()) {
            return response()->json([
                'status'       => 'success',
                'redirect_url' => $to,
            ]);
        }

        // Non-AJAX
        return redirect()->to($to);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
