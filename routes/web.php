<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/produk', [HomeController::class, 'produk']);
Route::get('/produk/{id}', [HomeController::class, 'detail']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:customer')->group(function () {
        Route::get('/profil', [CustomerController::class, 'profil']);
        Route::put('/profil/update', [CustomerController::class, 'updateProfil'])->name('profil.update');
        Route::get('/riwayat', [CustomerController::class, 'riwayat']);
        Route::get('/testimoni', [CustomerController::class, 'testimoni']);
        Route::post('/testimoni', [CustomerController::class, 'storeTestimoni']);
        Route::get('/pengaduan', [CustomerController::class, 'pengaduan']);
        Route::post('/pengaduan', [CustomerController::class, 'storePengaduan']);
        Route::post('/favorit/{id}', [CustomerController::class, 'favorit']);

        // Keranjang (Cart)
        Route::get('/keranjang', [CustomerController::class, 'keranjang'])->name('keranjang');
        Route::post('/keranjang/tambah/{id}', [CustomerController::class, 'tambahKeranjang'])->name('keranjang.tambah');
        Route::post('/keranjang/update/{id}', [CustomerController::class, 'updateKeranjang'])->name('keranjang.update');
        Route::post('/keranjang/hapus/{id}', [CustomerController::class, 'hapusKeranjang'])->name('keranjang.hapus');
        Route::post('/keranjang/checkout', [CustomerController::class, 'checkout'])->name('keranjang.checkout');
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/produk', [AdminController::class, 'produk']);
        Route::post('/produk', [AdminController::class, 'storeProduk'])->name('admin.produk.store');
        Route::put('/produk/{id}', [AdminController::class, 'updateProduk'])->name('admin.produk.update');
        Route::delete('/produk/{id}', [AdminController::class, 'destroyProduk'])->name('admin.produk.destroy');
        Route::get('/pelanggan', [AdminController::class, 'pelanggan']);
        Route::get('/pesanan', [AdminController::class, 'pesanan']);
        Route::get('/testimoni', [AdminController::class, 'testimoni']);
        Route::get('/pengaduan', [AdminController::class, 'pengaduan']);
    });
});
