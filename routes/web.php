<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JenisBencanaController;
use App\Http\Controllers\InventarisWebController;
use App\Http\Controllers\KejadianBencanaController;


Route::get('/', function () {
    return view('pages.publik.peta');
})->name('peta.publik');


Route::middleware(['auth'])->group(function () {

    // Halaman Dashboard umum
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('can:view dashboard')->name('dashboard');

    // Halaman Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // "GEDUNG ADMINISTRASI" - Semua fitur manajemen
    // DITEMPATKAN DI DALAM MIDDLEWARE 'auth'
    Route::prefix('admin')->name('admin.')->group(function () {

        // --- Modul Inventaris (Hanya untuk Staf & Super Admin) ---
        Route::prefix('inventaris')->name('inventaris.')
            ->middleware(['role:Staf BPBD|Super Admin']) // <-- Keamanan spesifik
            ->group(function () {
                Route::get('/', [InventarisWebController::class, 'index'])->name('index');
                Route::get('/{id}', [InventarisWebController::class, 'show'])->name('show');
            });

        // --- Modul Manajemen GIS (Hanya untuk Super Admin) ---
        Route::middleware(['role:Super Admin'])->group(function () {
            Route::resource('jenis-bencana', JenisBencanaController::class);
            Route::resource('kejadian', KejadianBencanaController::class);
        });
    });
});

Route::get('/logout-manual', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/'); // Arahkan ke halaman utama setelah logout
})->name('logout.manual');

require __DIR__ . '/auth.php';
