<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Fix for MySQL "Specified key was too long" error
        // When using utf8mb4, MySQL has a limit of 1000 bytes for index keys
        // Setting default string length to 191 ensures indexes work correctly
        Schema::defaultStringLength(191);
    }
}

