<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'],  // 🔥 IMPORTANTE: Debe coincidir con el frontend
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'exposed_headers' => ['Set-Cookie'],  // 🔥 Esto permite ver la cookie en el navegador
    'max_age' => 0,
    'supports_credentials' => true,  // 🔥 OBLIGATORIO PARA QUE LAS COOKIES FUNCIONEN
];
