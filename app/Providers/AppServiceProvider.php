<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {
        Schema::defaultStringLength(191);
    }
}
