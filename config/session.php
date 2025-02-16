<?php
return [
    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => false,
    'encrypt' => false,
    'http_only' => true,
    'same_site' => 'none',   // 🔥 Permite compartir cookies entre backend y frontend
    'secure' => false,       // 🔥 Debe ser `false` en desarrollo
    'domain' => env('SESSION_DOMAIN', '127.0.0.1'),
    'path' => '/',
];
