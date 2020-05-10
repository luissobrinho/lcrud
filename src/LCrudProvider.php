<?php

namespace Luissobrinho\LCrud;

use Luissobrinho\LForm\LFormProvider;
use Illuminate\Support\ServiceProvider;

class LCrudProvider extends ServiceProvider
{
    /**
     * Boot method.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Templates/Laravel' => base_path('resources/lcrud'),
            __DIR__.'/../config/lcrud.php' => base_path('config/lcrud.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */

        if (class_exists('Illuminate\Foundation\AliasLoader')) {
            $this->app->register(LFormProvider::class);
        }

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([
            \Luissobrinho\LCrud\Console\LCrud::class,
            \Luissobrinho\LCrud\Console\TableLCrud::class,
        ]);
    }
}
