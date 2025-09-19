<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoleRedirects
{
    public function handle(Request $request, Closure $next)
    {
        // ...
        if ($request->routeIs('login') && Auth::check()) {
            /** @var User $user */           // <-- tambahkan ini
            $user = Auth::user();            // sekarang linter tahu class-nya

            // Cek role spesifik terlebih dahulu (bukan Super Admin)
            if ($user->hasRole('PK')) {
                return redirect()->route('pk.dashboard');
            }
            if ($user->hasRole('KL')) {
                return redirect()->route('kl.dashboard');
            }
            if ($user->hasRole('RR')) {
                return redirect()->route('rr.dashboard');
            }
            
            // Super Admin sebagai fallback terakhir
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('admin.users.index');
            }

            return redirect()->intended('/dashboard');
        }

        return $next($request);
    }
}
