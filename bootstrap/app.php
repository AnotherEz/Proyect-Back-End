<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Session\Middleware\AuthenticateSession; // 🔹 Asegura que la sesión esté autenticada

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Habilitar Sanctum para autenticación con sesiones
        $middleware->alias([
            'sanctum' => EnsureFrontendRequestsAreStateful::class,
        ]);
        
        // ✅ Agregar Middleware de CORS correctamente
        $middleware->append(HandleCors::class);

        // ✅ Middleware para manejar sesiones y cookies correctamente
        $middleware->append(EncryptCookies::class);
        $middleware->append(StartSession::class);
        $middleware->append(AuthenticateSession::class); // 🔹 Asegura que la sesión se mantenga activa
        $middleware->append(ShareErrorsFromSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
