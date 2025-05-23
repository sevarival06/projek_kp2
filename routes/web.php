<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


use App\Http\Controllers\DashboardController;

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/data/{tahun}', [DashboardController::class, 'getDataByTahun']);

use App\Http\Controllers\SuratMasukController;

Route::resource('surat-masuk', SuratMasukController::class);
Route::get('surat-masuk/{id}/file', [SuratMasukController::class, 'viewFile'])->name('surat-masuk.view-file');
Route::get('surat-masuk/print/report', [SuratMasukController::class, 'printReport'])->name('surat-masuk.print');
Route::get('surat-masuk/print/disposisi/{id}', [SuratMasukController::class, 'printDisposisi'])->name('surat-masuk.print.disposisi');
Route::get('surat-masuk/view-file/{id}', [SuratMasukController::class, 'viewFile'])->name('surat-masuk.view-file');
Route::get('/surat-masuk/export-files', [SuratMasukController::class, 'exportFiles'])
    ->name('surat-masuk.export-files');
Route::post('/surat-masuk/download-files', [App\Http\Controllers\SuratMasukController::class, 'downloadFiles'])->name('surat-masuk.download-files');


use App\Http\Controllers\AuthControllerController;
// Authentication Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/edit-profil', [App\Http\Controllers\AuthController::class, 'edit'])->name('edit.profil');
Route::post('/update-profil', [App\Http\Controllers\AuthController::class, 'update'])->name('update.profil');
// Route untuk profil (edit dan update)
Route::get('/profile', [App\Http\Controllers\AuthController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [App\Http\Controllers\AuthController::class, 'update'])->name('profile.update');