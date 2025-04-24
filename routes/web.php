<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste-url', function () {
    $path = '1/foto_67ffcc1a504455.41351605.jpg';
    return Storage::disk('minio')->temporaryUrl($path, now()->addMinutes(5));
});

