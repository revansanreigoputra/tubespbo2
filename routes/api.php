<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

use App\Http\Controllers\Api\PesananController;
Route::resource('pesanans', PesananController::class);


//posts
Route::apiResource('/pelanggans', App\Http\Controllers\Api\PelangganController::class);