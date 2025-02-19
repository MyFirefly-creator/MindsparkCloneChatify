<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\WarningController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriBukuController;

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

Route::get('/', [UserController::class, 'index'])->name('index');

Route::prefix('sesi')->group(function () {
    Route::get('/login', [UserController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware(['ban'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard.index');

});

Route::get('/ban', [BanController::class, 'index'])->name('ban.index');

Route::middleware(['auth', 'ban', 'role:admin,superadmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::middleware(['auth', 'ban', 'superadmin'])->group(function () {
    Route::get('admin/users', [AdminController::class, 'user'])->name('admin.users');
    Route::get('admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::post('/ban', [BanController::class, 'store'])->name('ban.store');
    Route::post('/warnings/store', [AdminController::class, 'storeWarning'])->name('warnings.store');
});

Route::middleware(['auth', 'admin','ban'])->group(function () {
    Route::get('/admin/verifikasi', [AdminController::class, 'daftarVerifikasi'])->name('admin.verifikasi.list');
    Route::get('/admin/verifikasi/{id}/{status}', [AdminController::class, 'verifikasiUser'])->name('admin.verifikasi');

    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

    Route::get('/kategori_buku', [KategoriBukuController::class, 'index'])->name('kategori_buku.index');
    Route::get('/kategori_buku/create', [KategoriBukuController::class, 'create'])->name('kategori_buku.create');
    Route::post('/kategori_buku', [KategoriBukuController::class, 'store'])->name('kategori_buku.store');
    Route::get('/kategori_buku/{kategoriBuku}/edit', [KategoriBukuController::class, 'edit'])->name('kategori_buku.edit');
    Route::put('/kategori_buku/{kategoriBuku}', [KategoriBukuController::class, 'update'])->name('kategori_buku.update');
    Route::delete('/kategori_buku/{kategoriBuku}', [KategoriBukuController::class, 'destroy'])->name('kategori_buku.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');


});

Route::get('/search-users', [AdminController::class, 'searchUsers'])->name('search.users');
Route::get('/peminjaman/search', [PeminjamanController::class, 'search'])->name('peminjaman.search');

Route::middleware(['auth','ban'])->group(function () {
    Route::get('/settings', [UserController::class, 'setting'])->name('settings');
    Route::get('/sesi/edit/{id}', [UserController::class, 'edit'])->name('sesi.edit');
    Route::put('/sesi/update/{id}', [UserController::class, 'update'])->name('sesi.update');

    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('peminjaman/show/{userId}', [PeminjamanController::class, 'showUserHistory'])->name('peminjaman.show');
    Route::get('laporan-peminjaman', [PeminjamanController::class, 'laporan'])->name('peminjaman.laporan');

    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');

    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit', [FavoritController::class, 'store'])->name('favorit.store');
    Route::delete('/favorit/{id}', [FavoritController::class, 'destroy'])->name('favorit.destroy');

    Route::get('buku/{bukuID}', [BukuController::class, 'show'])->name('buku.show');
    Route::post('ulasans/{bukuID}', [UlasanController::class, 'store'])->name('ulasans.store');
});



