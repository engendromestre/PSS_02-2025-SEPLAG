<?php

use App\Http\Controllers\PessoaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);


Route::apiResource('pessoas', PessoaController::class)->except([
    'create',
    'show',
    'edit'
]);
