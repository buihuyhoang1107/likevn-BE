<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Facebook Buff API',
        'version' => '1.0.0',
    ]);
});

