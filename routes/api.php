<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 🔹 Rutas de autenticación

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [AuthController::class, 'getUsers']); // Protegida
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/dashboard', [UserController::class, 'dashboard']);
});

Route::post('/register', [AuthController::class, 'register']); 


// 🔹 Rutas de recuperación de contraseña
Route::post('/forgot-password', [AuthController::class, 'sendResetCode']); 
Route::post('/verify-code', [AuthController::class, 'verifyCode']); 
Route::post('/reset-password', [AuthController::class, 'resetPassword']); 

// 🔹 Ruta protegida con Sanctum para el Dashboard
Route::middleware(['auth:sanctum'])->get('/dashboard', [DashboardController::class, 'index']);

// 🔹 Ruta para obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
    ]);
});

