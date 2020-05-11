<?php

namespace Luissobrinho\LForm\Facades;

use Illuminate\Support\Facades\Facade;

class LForm extends Facade
{
    /**
     * Create the Facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LForm';
    }
}
