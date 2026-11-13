<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerKaryawan;
use App\Http\Controllers\ControllerSupplier;

// Redirect root ke halaman Karyawan
Route::get('/', function () {
    return redirect('/karyawan');
});

// Route Karyawan (URL bersih persis Rangkuman Halaman 5)
Route::get('/karyawan', [ControllerKaryawan::class, 'index']);
Route::get('/karyawan/create', [ControllerKaryawan::class, 'create']);
Route::post('/karyawan', [ControllerKaryawan::class, 'store']);
Route::get('/karyawan/{kode}/edit', [ControllerKaryawan::class, 'edit']);
Route::put('/karyawan', [ControllerKaryawan::class, 'update']);
Route::delete('/karyawan', [ControllerKaryawan::class, 'destroy']);

// Route Supplier (URL bersih persis Rangkuman Halaman 5)
Route::get('/supplier', [ControllerSupplier::class, 'index']);
Route::get('/supplier/create', [ControllerSupplier::class, 'create']);
Route::post('/supplier', [ControllerSupplier::class, 'store']);
Route::get('/supplier/{kode}/edit', [ControllerSupplier::class, 'edit']);
Route::put('/supplier', [ControllerSupplier::class, 'update']);
Route::delete('/supplier', [ControllerSupplier::class, 'destroy']);
