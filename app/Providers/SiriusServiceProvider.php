<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SiriusServiceProvider extends ServiceProvider
{
    public function register()
    {
        require_once app_path().'/Helpers/Sirius.php';
    }

    public function boot()
    {
        //
    }
}
