<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Laravel soporta varios tipos de almacenamiento de sesiones.
    | Para React + Sanctum, lo mejor es usar "cookie".
    |
    */
    'driver' => env('SESSION_DRIVER', 'cookie'),
'domain' => env('SESSION_DOMAIN', null),
'secure' => false, // Cambia a true si usas HTTPS
'same_site' => 'lax',


    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Número de minutos que la sesión será válida.
    | Si quieres que se cierre al cerrar el navegador, usa `expire_on_close = true`.
    |
    */
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | Desactiva esta opción para evitar problemas con React.
    |
    */
    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | Si usas el driver "file", Laravel guardará las sesiones en este directorio.
    |
    */
    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | Para usar "database" como driver de sesión, indica la conexión aquí.
    |
    */
    'connection' => env('SESSION_CONNECTION', null),
    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | Para usar "redis" u otro caché como backend de sesión.
    |
    */
    'store' => env('SESSION_STORE', null),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Cambia el nombre de la cookie si deseas.
    |
    */
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    */
    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Configura esto si tu frontend y backend están en diferentes dominios.
    |
    */
  

    /*
    |--------------------------------------------------------------------------
    | Secure & HTTP-Only Cookies
    |--------------------------------------------------------------------------
    |
    | Si usas HTTPS, activa `secure = true`, de lo contrario déjalo en `false`.
    | HTTP Only impide que JS acceda a la cookie.
    |
    */
   
    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | Para permitir autenticación desde React, usa `none` si estás en dominios distintos.
    | Si React y Laravel están en el mismo dominio, `lax` funciona bien.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies (Experimental)
    |--------------------------------------------------------------------------
    */
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
