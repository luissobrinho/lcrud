<?php

namespace Luissobrinho\LCrud;

class LumenLCrudProvider extends LCrudProvider
{
    /**
     * Boot method.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->app->configure('lcrud');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->commands([
            \Luissobrinho\LCrud\Console\Publish::class,
        ]);
    }
}
