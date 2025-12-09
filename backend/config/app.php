<?php

return [
    'name' => env('APP_NAME', 'PUNTO TATTO API'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'locale' => env('APP_LOCALE', 'es'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'es'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'es_MX'),
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
];

