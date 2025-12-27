<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratKeluarController;


/*
|--------------------------------------------------------------------------
| AUTH & LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

    // SURAT MASUK - VIEW & DOWNLOAD
    Route::get('/surat-masuk/{id}/view', [SuratMasukController::class, 'viewFile'])
        ->name('surat-masuk.view');

    Route::get('/surat-masuk/{id}/download', [SuratMasukController::class, 'download'])
        ->name('surat-masuk.download');

    // SURAT MASUK - CRUD
    Route::resource('surat-masuk', SuratMasukController::class);
});

    Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

    Route::middleware(['auth'])->group(function () {

    Route::get('/surat-keluar/{id}/view', [SuratKeluarController::class, 'viewFile'])
        ->name('surat-keluar.view');

    Route::get('/surat-keluar/{id}/download', [SuratKeluarController::class, 'download'])
        ->name('surat-keluar.download');

    Route::resource('surat-keluar', SuratKeluarController::class);
});

