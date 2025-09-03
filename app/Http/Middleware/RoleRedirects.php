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

            if ($user->hasRole('Super Admin')) {
                return redirect()->route('admin.users.index');
            }
            if ($user->hasRole('PK')) {
                return redirect()->route('pk.dashboard');
            }
            if ($user->hasRole('KL')) {
                return redirect()->route('kl.dashboard');
            }
            if ($user->hasRole('RR')) {
                return redirect()->route('rr.dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return $next($request);
    }
}
