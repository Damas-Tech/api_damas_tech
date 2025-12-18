<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name' => 'Damas Tech API',
        'status' => 'ok',
        'health' => url('/api/health'),
        'docs' => url('/api/docs/openapi'),
    ]);
});
