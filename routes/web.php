<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// ===================== ADMIN AREA =====================
use App\Http\Controllers\Role\KL\KLController;
use App\Http\Controllers\Role\PK\PKController;
use App\Http\Controllers\Role\RR\RRController;
use App\Http\Controllers\Role\KL\LogistikController;
use App\Http\Controllers\Role\KL\JenisBencanaController;
use App\Http\Controllers\Role\Shared\ActivityReportController;

// ===================== ROLE =====================
use App\Http\Controllers\Role\KL\SkController         as KlSkController;
use App\Http\Controllers\Role\PK\SkController         as PkSkController;

use App\Http\Controllers\Role\RR\SkController         as RrSkController;
use App\Http\Controllers\Role\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Role\Admin\RekapLogistikController as AdminRekap;
use App\Http\Controllers\Role\Admin\SkController        as AdminSkController;

use App\Http\Controllers\Role\Admin\UserController      as AdminUserController;
use App\Http\Controllers\Role\Admin\ReportController    as AdminReportController;

// ===================== SHARED (lintas role) =====================
use App\Http\Controllers\Role\KL\KejadianBencanaController as KlKejadianBencanaController;
use App\Http\Controllers\Role\Admin\KejadianBencanaController as AdminKejadianBencanaController;

/*
|--------------------------------------------------------------------------
| Publik
|--------------------------------------------------------------------------
*/

Route::view('/',       'pages.publik.peta')->name('peta.publik');
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

        // Cek role spesifik terlebih dahulu (bukan Super Admin)
        if ($u->hasRole('PK'))          return redirect()->route('pk.dashboard');
        if ($u->hasRole('KL'))          return redirect()->route('kl.dashboard');
        if ($u->hasRole('RR'))          return redirect()->route('rr.dashboard');
        
        // Super Admin sebagai fallback terakhir
        if ($u->hasRole('Super Admin')) return redirect()->route('admin.dashboard');

        return view('dashboard');
    })->name('dashboard');
    // Profile
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin (Super Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:Super Admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Rekap Kegiatan (existing)
    Route::prefix('rekap-kegiatan')->name('rekap-kegiatan.')->group(function () {
        Route::get('/rekap-bulanan',                    [AdminReportController::class, 'adminRecapRedirect'])->name('rekap');
        Route::get('/rekap-bulanan/role/{role}',        [AdminReportController::class, 'adminRecapRoleIndex'])
            ->where('role', 'PK|KL|RR')->name('rekap.role.index');
        Route::get('/rekap-bulanan/{ym}/pdf',           [AdminReportController::class, 'adminRecapMonthPdf'])
            ->where('ym', '\d{4}-\d{2}')->name('rekap.month.pdf');
        Route::get('/rekap-bulanan/{ym}/{role}/pdf',    [AdminReportController::class, 'adminRecapMonthRolePdf'])
            ->where(['ym' => '\d{4}-\d{2}', 'role' => 'PK|KL|RR'])->name('rekap.month.role.pdf');
    });

    // Rekap Logistik (existing)
    Route::prefix('logistik')->name('logistik.')->group(function () {
        Route::get('/rekap',            [AdminRekap::class, 'years'])->name('rekap.index');
        Route::get('/rekap/{year}',     [AdminRekap::class, 'index'])->whereNumber('year')->name('rekap');
        Route::get('/rekap/{year}/pdf', [AdminRekap::class, 'pdf'])->whereNumber('year')->name('rekap.pdf');
    });

    // Manajemen User (existing)
    Route::resource('manajemen-user', AdminUserController::class)->except(['show']);
    Route::get('manajemen-user/role/{role}', [AdminUserController::class, 'byRole'])
        ->where('role', 'PK|KL|RR|Staf BPBD')->name('manajemen-user.byrole');
    Route::post('manajemen-user/{user}/resend-verification', [AdminUserController::class, 'resendVerification'])->name('manajemen-user.resend');
    Route::post('manajemen-user/{user}/reset-password',      [AdminUserController::class, 'resetPassword'])->name('manajemen-user.reset');

    // === SK (Admin melihat SEMUA data) ===
    Route::prefix('sk')->name('sk.')->group(function () {
        Route::get('/',             [AdminSkController::class, 'index'])->name('index');
        Route::get('/create',       [AdminSkController::class, 'create'])->name('create');
        Route::post('/',            [AdminSkController::class, 'store'])->name('store');
        Route::get('/{sk}/edit',    [AdminSkController::class, 'edit'])->name('edit');
        Route::put('/{sk}',         [AdminSkController::class, 'update'])->name('update');
        Route::delete('/{sk}',      [AdminSkController::class, 'destroy'])->name('destroy');
        Route::get('/{sk}/download', [AdminSkController::class, 'download'])->name('download');

        // Rekap (URL helper → tab rekap di halaman index)
        Route::get('/rekap/{year?}',    [AdminSkController::class, 'rekap'])->whereNumber('year')->name('rekap');
        Route::get('/rekap/{year}/pdf', [AdminSkController::class, 'rekapPdf'])->whereNumber('year')->name('rekap.pdf');
    });
});

/*
|--------------------------------------------------------------------------
| PK
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:PK'])
    ->prefix('pk')->name('pk.')
    ->group(function () {
        Route::get('/dashboard', [PKController::class, 'index'])->name('dashboard');

        // Laporan Kegiatan (SHARED)
        Route::resource('lap-kegiatan', ActivityReportController::class)
            ->parameters(['lap-kegiatan' => 'report'])->names('lap-kegiatan');
        Route::get('lap-kegiatan/{report}/pdf', [ActivityReportController::class, 'pdf'])->name('lap-kegiatan.pdf');

        // === SK (PK) ===
        Route::prefix('sk')->name('sk.')->group(function () {
            Route::get('/',             [PkSkController::class, 'index'])->name('index');
            Route::get('/create',       [PkSkController::class, 'create'])->name('create');
            Route::post('/',            [PkSkController::class, 'store'])->name('store');
            Route::get('/{sk}/edit',    [PkSkController::class, 'edit'])->name('edit');
            Route::put('/{sk}',         [PkSkController::class, 'update'])->name('update');
            Route::delete('/{sk}',      [PkSkController::class, 'destroy'])->name('destroy');
            Route::get('/{sk}/download', [PkSkController::class, 'download'])->name('download');

            Route::get('/rekap/{year?}',    [PkSkController::class, 'rekap'])->whereNumber('year')->name('rekap');
            Route::get('/rekap/{year}/pdf', [PkSkController::class, 'rekapPdf'])->whereNumber('year')->name('rekap.pdf');
        });
    });

/*
|--------------------------------------------------------------------------
| KL
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:KL'])
    ->prefix('kl')->name('kl.')
    ->group(function () {
        Route::get('/dashboard', [KLController::class, 'index'])->name('dashboard');

        // Laporan Kegiatan (SHARED)
        Route::resource('lap-kegiatan', ActivityReportController::class)
            ->parameters(['lap-kegiatan' => 'report'])->names('lap-kegiatan');
        Route::get('lap-kegiatan/{report}/pdf', [ActivityReportController::class, 'pdf'])->name('lap-kegiatan.pdf');

        // LOGISTIK (tetap seperti sebelumnya)
        Route::prefix('logistik')->name('logistik.')->group(function () {
            Route::get('/',              [LogistikController::class, 'index'])->name('index');
            Route::get('/create',        [LogistikController::class, 'create'])->name('create');
            Route::post('/',             [LogistikController::class, 'store'])->name('store');
            Route::get('/{item}/edit',   [LogistikController::class, 'edit'])->name('edit');
            Route::put('/{item}',        [LogistikController::class, 'update'])->name('update');
            Route::delete('/{item}',     [LogistikController::class, 'destroy'])->name('destroy');
        });

        // Kejadian Bencana
        Route::resource('kejadian-bencana', KlKejadianBencanaController::class);
        Route::get('kejadian-bencana-import', [KlKejadianBencanaController::class, 'importForm'])->name('kejadian-bencana.import.form');
        Route::post('kejadian-bencana-import', [KlKejadianBencanaController::class, 'importStore'])->name('kejadian-bencana.import.store');
        Route::resource('jenis-bencana', JenisBencanaController::class);



        // === SK (KL) ===
        Route::prefix('sk')->name('sk.')->group(function () {
            Route::get('/',             [KlSkController::class, 'index'])->name('index');
            Route::get('/create',       [KlSkController::class, 'create'])->name('create');
            Route::post('/',            [KlSkController::class, 'store'])->name('store');
            Route::get('/{sk}/edit',    [KlSkController::class, 'edit'])->name('edit');
            Route::put('/{sk}',         [KlSkController::class, 'update'])->name('update');
            Route::delete('/{sk}',      [KlSkController::class, 'destroy'])->name('destroy');
            Route::get('/{sk}/download', [KlSkController::class, 'download'])->name('download');

            Route::get('/rekap/{year?}',    [KlSkController::class, 'rekap'])->whereNumber('year')->name('rekap');
            Route::get('/rekap/{year}/pdf', [KlSkController::class, 'rekapPdf'])->whereNumber('year')->name('rekap.pdf');
        });
    });

/*
|--------------------------------------------------------------------------
| RR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:RR'])
    ->prefix('rr')->name('rr.')
    ->group(function () {
        Route::get('/dashboard', [RRController::class, 'index'])->name('dashboard');

        // Laporan Kegiatan (SHARED)
        Route::resource('lap-kegiatan', ActivityReportController::class)
            ->parameters(['lap-kegiatan' => 'report'])->names('lap-kegiatan');
        Route::get('lap-kegiatan/{report}/pdf', [ActivityReportController::class, 'pdf'])->name('lap-kegiatan.pdf');

        // === SK (RR) ===
        Route::prefix('sk')->name('sk.')->group(function () {
            Route::get('/',             [RrSkController::class, 'index'])->name('index');
            Route::get('/create',       [RrSkController::class, 'create'])->name('create');
            Route::post('/',            [RrSkController::class, 'store'])->name('store');
            Route::get('/{sk}/edit',    [RrSkController::class, 'edit'])->name('edit');
            Route::put('/{sk}',         [RrSkController::class, 'update'])->name('update');
            Route::delete('/{sk}',      [RrSkController::class, 'destroy'])->name('destroy');
            Route::get('/{sk}/download', [RrSkController::class, 'download'])->name('download');

            Route::get('/rekap/{year?}',    [RrSkController::class, 'rekap'])->whereNumber('year')->name('rekap');
            Route::get('/rekap/{year}/pdf', [RrSkController::class, 'rekapPdf'])->whereNumber('year')->name('rekap.pdf');
        });
    });

require __DIR__ . '/auth.php';
