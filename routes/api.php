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

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('checkRole:admin,editor')->group(function () {
        Route::post('/pessoas', [PessoaController::class, 'store']);
        Route::put('/pessoas/{pessoa}', [PessoaController::class, 'update']);
        Route::delete('/pessoas/{pessoa}', [PessoaController::class, 'destroy']);
        
        Route::post('/fotos-pessoas', [FotoPessoaController::class, 'store']);
    });

    Route::middleware('checkRole:admin,editor,user')->group(function () {
        Route::get('/pessoas', [PessoaController::class, 'index']);
        Route::get('/pessoas/{pessoa}', [PessoaController::class, 'show']);
    });
});


