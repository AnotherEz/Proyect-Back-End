<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// 🔹 NECESARIO PARA QUE SANCTUM FUNCIONE CON COOKIES
Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// 🔹 AUTENTICACIÓN
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// 🔹 RECUPERACIÓN DE CONTRASEÑA
Route::post('/forgot-password', [AuthController::class, 'sendResetCode']); 
Route::post('/verify-code', [AuthController::class, 'verifyCode']); 
Route::post('/reset-password', [AuthController::class, 'resetPassword']); 

// 🔹 RUTA PARA OBTENER EL TOKEN CSRF (NECESARIO PARA SANCTUM)
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});
