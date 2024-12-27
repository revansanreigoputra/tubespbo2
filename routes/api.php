<?php

use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\PelangganController;
use Illuminate\Support\Facades\Route;

// Route untuk Pesanan
Route::get('/pesanan', [PesananController::class, 'index']);
Route::post('/pesanan', [PesananController::class, 'store']);
Route::get('/pesanan/{id}', [PesananController::class, 'show']);
Route::put('/pesanan/{id}', [PesananController::class, 'update']);
Route::delete('/pesanan/{id}', [PesananController::class, 'destroy']);

// Route untuk Pelanggan
Route::apiResource('/pelanggans', PelangganController::class);
