<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JenisBencanaController;
use App\Http\Controllers\InventarisWebController;
use App\Http\Controllers\KejadianBencanaController;

// ===================== ADMIN AREA (namespace baru) =====================
use App\Http\Controllers\Role\Admin\UserController as AdminUserController;
use App\Http\Controllers\Role\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Role\Admin\DashboardController;
use App\Http\Controllers\Role\Admin\RekapLogistikController as AdminRekap;

// ===================== ROLE PK/KL/RR =====================
use App\Http\Controllers\Role\PKController;
use App\Http\Controllers\Role\KLController;
use App\Http\Controllers\Role\ActivityReportController;
use App\Http\Controllers\Role\RRController;

// ===================== KL submodule (namespace baru) ====================
use App\Http\Controllers\Role\KL\LogistikController;
use App\Http\Controllers\Role\KL\SkController;
use App\Http\Controllers\Role\KL\SkRekapController;

/*
|--------------------------------------------------------------------------
| Publik
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.publik.peta')->name('peta.publik');
Route::view('/grafik', 'pages.publik.grafik')->name('grafik.publik');

/*
|--------------------------------------------------------------------------
| Auth + Verified (Umum)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        /** @var \App\Models\User|null $u */
        $u = Auth::user();

        if (!$u) return redirect()->route('login');

        if ($u->hasRole('Super Admin')) return redirect()->route('admin.dashboard');
        if ($u->hasRole('PK'))          return redirect()->route('pk.dashboard');
        if ($u->hasRole('KL'))          return redirect()->route('kl.dashboard');
        if ($u->hasRole('RR'))          return redirect()->route('rr.dashboard');

        return view('dashboard');
    })->name('dashboard');

    // Profile pengguna
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin & (Inventaris untuk Super Admin / Staf BPBD)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    // Inventaris – Super Admin & Staf BPBD
    // Area khusus Super Admin
    Route::middleware(['role:Super Admin'])->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ================== (REKAP ADMIN) ==================
        Route::prefix('rekap-kegiatan')->name('rekap-kegiatan.')->group(function () {
            Route::get('/rekap-bulanan', [AdminReportController::class, 'adminRecapRedirect'])->name('rekap');
            Route::get('/rekap-bulanan/role/{role}', [AdminReportController::class, 'adminRecapRoleIndex'])
                ->where('role', 'PK|KL|RR')->name('rekap.role.index');
            Route::get('/rekap-bulanan/{ym}/pdf', [AdminReportController::class, 'adminRecapMonthPdf'])
                ->where('ym', '\d{4}-\d{2}')->name('rekap.month.pdf');
            Route::get('/rekap-bulanan/{ym}/{role}/pdf', [AdminReportController::class, 'adminRecapMonthRolePdf'])
                ->where(['ym' => '\d{4}-\d{2}', 'role' => 'PK|KL|RR'])->name('rekap.month.role.pdf');
        });

        Route::prefix('logistik')->name('logistik.')->group(function () {
            // halaman daftar tahun
            Route::get('/rekap',            [AdminRekap::class, 'years'])->name('rekap.index');

            // detail per tahun + PDF
            Route::get('/rekap/{year}',     [AdminRekap::class, 'index'])->whereNumber('year')->name('rekap');
            Route::get('/rekap/{year}/pdf', [AdminRekap::class, 'pdf'])->whereNumber('year')->name('rekap.pdf');
        });

        // Manajemen User
        Route::resource('manajemen-user', AdminUserController::class)->except(['show']);

        // Filter per role (PK | KL | RR | Staf BPBD)
        Route::get('manajemen-user/role/{role}', [AdminUserController::class, 'byRole'])
            ->where('role', 'PK|KL|RR|Staf BPBD')
            ->name('manajemen-user.byrole');

        // Aksi tambahan (opsional)
        Route::post('manajemen-user/{user}/resend-verification', [AdminUserController::class, 'resendVerification'])->name('manajemen-user.resend');
        Route::post('manajemen-user/{user}/reset-password',      [AdminUserController::class, 'resetPassword'])->name('manajemen-user.reset');
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard per-role + lap-kegiatan Kegiatan (CRUD + PDF)
|--------------------------------------------------------------------------
*/
// PK
Route::middleware(['auth', 'verified', 'role:PK'])
    ->prefix('pk')->name('pk.')
    ->group(function () {
        Route::get('/dashboard', [PKController::class, 'index'])->name('dashboard');

        Route::resource('lap-kegiatan', ActivityReportController::class)
            ->parameters(['lap-kegiatan' => 'lap-kegiatan'])->names('lap-kegiatan');
        Route::get('lap-kegiatan/{report}/pdf', [ActivityReportController::class, 'pdf'])->name('lap-kegiatan.pdf');
    });

// KL
Route::middleware(['auth', 'verified', 'role:KL'])
    ->prefix('kl')->name('kl.')
    ->group(function () {
        Route::get('/dashboard', [KLController::class, 'index'])->name('dashboard');

        Route::resource('lap-kegiatan', ActivityReportController::class)
            ->parameters(['lap-kegiatan' => 'report'])->names('lap-kegiatan');
        Route::get('lap-kegiatan/{report}/pdf', [ActivityReportController::class, 'pdf'])->name('lap-kegiatan.pdf');

        // Data SK (CRUD)
        Route::resource('sk', SkController::class)->except(['show']);
        Route::get('sk/{sk}/download', [SkController::class, 'download'])->name('sk.download');

        // Rekap SK — dengan PDF
        Route::prefix('sk/rekap')->name('sk.rekap.')->group(function () {
            Route::get('/',          [SkRekapController::class, 'years'])->name('years');
            Route::get('{year}',     [SkRekapController::class, 'index'])->whereNumber('year')->name('year');
            Route::get('{year}/pdf', [SkRekapController::class, 'pdf'])->whereNumber('year')->name('pdf');
        });
    });

// RR
Route::middleware(['auth', 'verified', 'role:RR'])
    ->prefix('rr')->name('rr.')
    ->group(function () {
        Route::get('/dashboard', [RRController::class, 'index'])->name('dashboard');

        Route::resource('lap-kegiatan', ActivityReportController::class)
            ->parameters(['lap-kegiatan' => 'report'])->names('lap-kegiatan');
        Route::get('lap-kegiatan/{report}/pdf', [ActivityReportController::class, 'pdf'])->name('lap-kegiatan.pdf');
    });

// KL Logistik (module baru di role/kl/logistik)
Route::middleware(['auth'])
    ->prefix('role/kl/logistik')->name('role.kl.logistik.')
    ->group(function () {
        Route::get('/',              [LogistikController::class, 'index'])->name('index');
        Route::get('/create',        [LogistikController::class, 'create'])->name('create');
        Route::post('/',             [LogistikController::class, 'store'])->name('store');

        Route::get('/{item}/edit',   [LogistikController::class, 'edit'])->name('edit');
        Route::put('/{item}',        [LogistikController::class, 'update'])->name('update');
        Route::delete('/{item}',     [LogistikController::class, 'destroy'])->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| Auth scaffolding
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
