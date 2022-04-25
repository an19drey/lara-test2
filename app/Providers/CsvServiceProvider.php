<?php

namespace App\Providers;

use App\Models\Sources\Csv\CsvCreator;
use Illuminate\Support\ServiceProvider;

class CsvServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('CsvCreator', function ($app) {
            return new CsvCreator();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
