<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'PUNTO TATTO API',
        'version' => '1.0.0',
    ]);
});

