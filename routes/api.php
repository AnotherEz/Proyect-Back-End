<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// 🔹 RUTA PARA OBTENER EL TOKEN CSRF (NECESARIO PARA SANCTUM CON COOKIES)
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// 🔹 AUTENTICACIÓN
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/forgot-password', [AuthController::class, 'sendResetCode']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// 🔹 RUTAS PROTEGIDAS POR SANCTUM
Route::middleware([
    EnsureFrontendRequestsAreStateful::class, // ✅ Permite manejar sesiones con cookies
    'auth:sanctum',
])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
});
