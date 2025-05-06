<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\FotoPessoaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth - Rotas públicas (sem autenticação)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

// Auth - Rotas protegidas (requerem autenticação)
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('refresh', [AuthController::class, 'refreshToken'])->name('auth.refresh');
});

// Permissions - Rotas protegidas (requerem autenticação)
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('checkRole:admin,editor')->group(function () {
        Route::post('/pessoas', [PessoaController::class, 'store'])->name('pessoas.store');
        Route::put('/pessoas/{pessoa}', [PessoaController::class, 'update'])->name('pessoas.update');
        Route::delete('/pessoas/{pessoa}', [PessoaController::class, 'destroy'])->name('pessoas.destroy');
        
        // Endpoint para vincular fotos à pessoa
        Route::post('/pessoas/{pessoa}/fotos', [FotoPessoaController::class, 'store'])->name('pessoas.fotos.store');

        Route::post('/unidades', [UnidadeController::class, 'store'])->name('unidades.store');
        Route::put('/unidades/{unidade}', [UnidadeController::class, 'update'])->name('unidades.update');
        Route::delete('/unidades/{unidade}', [UnidadeController::class, 'destroy'])->name('unidades.destroy');

        // Endpoint para vincular endereço à unidade
        Route::post('/unidades/{unidade}/enderecos', [UnidadeEnderecoController::class, 'store'])->name('unidades.enderecos.store');
    });

    Route::middleware('checkRole:admin,editor,user')->group(function () {
        Route::get('/pessoas', [PessoaController::class, 'index'])->name('pessoas.index');
        Route::get('/pessoas/{pessoa}', [PessoaController::class, 'show'])->name('pessoas.show');

        Route::get('/unidades', [UnidadeController::class, 'index'])->name('unidades.index');
        Route::get('/unidades/{unidade}', [UnidadeController::class, 'show'])->name('unidades.show');

        // Endpoint para listar servidores eafetivos por unidade (requisito do projeto)
        Route::get('/unidades/{unidade}/servidores-efetivos', [UnidadeController::class, 'servidoresEfetivos'])->name('unidades.servidores-efetivos');
    });
});


