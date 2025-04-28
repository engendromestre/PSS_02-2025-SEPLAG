<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\FotoPessoaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rotas públicas (sem autenticação)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

// Rotas protegidas (requerem autenticação)
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('refresh', [AuthController::class, 'refreshToken'])->name('auth.refresh');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('checkRole:admin,editor')->group(function () {
        Route::post('/pessoas', [PessoaController::class, 'store'])->name('pessoas.store');
        Route::put('/pessoas/{pessoa}', [PessoaController::class, 'update'])->name('pessoas.update');
        Route::delete('/pessoas/{pessoa}', [PessoaController::class, 'destroy'])->name('pessoas.destroy');
        
        Route::post('/pessoas/{pessoa}/fotos', [FotoPessoaController::class, 'store'])->name('pessoas.fotos.store');
    });

    Route::middleware('checkRole:admin,editor,user')->group(function () {
        Route::get('/pessoas', [PessoaController::class, 'index'])->name('pessoas.index');
        Route::get('/pessoas/{pessoa}', [PessoaController::class, 'show'])->name('pessoas.show');
    });
});


