<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\PenimbanganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\JadwalKontenController;
use App\Http\Controllers\FileKontenController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LaporanJadwalKontenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Route::get('/notifications/read/{id}', [App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
// Route::get('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

// Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
// Route::get('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

Route::get('/notifications/mark-read/{id}', [NotificationController::class, 'markRead'])->name('notifications.markRead');
Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

Route::resource('/kategoris', KategoriController::class);
Route::resource('/jadwal_kontens', JadwalKontenController::class);
Route::resource('/file_kontens', FileKontenController::class);
Route::patch('/jadwal_kontens/{id}/status', [JadwalKontenController::class, 'updateStatus'])->name('jadwal_kontens.updateStatus');
Route::get('/kalender-jadwal', [App\Http\Controllers\JadwalKontenController::class, 'kalender'])->name('jadwal_kontens.kalender');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});




Route::get('/laporan/jadwal-konten', [LaporanJadwalKontenController::class, 'showForm'])->name('laporan.jadwal.view');
Route::get('/laporan/jadwal-konten/export', [LaporanJadwalKontenController::class, 'exportExcel'])->name('laporan.jadwal.export');



Route::resource('/akun' ,AkunController::class);
