<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Habilita CORS en API y Sanctum
    'allowed_methods' => ['*'], // Permite todos los métodos (GET, POST, etc.)
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Permite todos los headers
    'exposed_headers' => [],
    'supports_credentials' => true, // Importante para enviar cookies desde el frontend
];

