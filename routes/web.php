<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Bienvenido a la API de Laravel";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
