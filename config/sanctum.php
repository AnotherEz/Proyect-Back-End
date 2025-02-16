<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Requests from the following domains / hosts will receive stateful API
    | authentication cookies. Aquí debes incluir la URL de tu frontend React.
    |
    */
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS')),



    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | Definimos los guards que usará Sanctum. Para un backend API con React, 
    | es importante mantener "web" aquí.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | Tiempo de expiración para los tokens de acceso. Si usas sesiones 
    | con cookies (SPA con React), deja esto en null.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | Prefijo opcional para los tokens, útil para evitar exponer credenciales
    | en repositorios públicos por error.
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | Laravel Sanctum maneja sesiones con estos middlewares, los cuales 
    | verifican autenticación y protegen contra CSRF.
    |
    */

    'middleware' => [
        'authenticate_session' => Illuminate\Session\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],
    
];
