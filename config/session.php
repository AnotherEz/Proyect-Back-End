<?php

return [
    'driver' => env('SESSION_DRIVER', 'cookie'), // ✅ DEBE ser 'cookie'
    'lifetime' => 120, // ✅ Duración en minutos
    'expire_on_close' => false,
    'encrypt' => false,
    'http_only' => true,
    'secure' => env('SESSION_SECURE_COOKIE', false), // ✅ false en desarrollo
    'same_site' => 'lax', // ✅ Permite compartir cookies entre frontend y backend
];
