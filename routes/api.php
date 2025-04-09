<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PessoaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum', 'checkRole:admin,editor')->group(function () {
    Route::get('/pessoas', [PessoaController::class, 'index']);
    Route::post('/pessoas', [PessoaController::class, 'store']);
});
