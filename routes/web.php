<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Bienvenido a la API de Laravel";
});
Route::get('/login', function () {
    return response()->json(['message' => 'Página de login no encontrada'], 404);
})->name('login');
