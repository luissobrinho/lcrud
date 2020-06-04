<?php

namespace Luissobrinho\LCrud\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method create($name, $config, $object = null, $class = null, $reformatted = false, $populated = true)
 * @method getObjectValue($object, $name)
 * @method inputStringPreparer($config)
 * @method label($name, $attributes = [])
 * @method prepareTheClass($class, $config)
 * @method getInput()
 * @method prepareType($config)
 * @method prepareObjectValue($config)
 * @method getGeneratorMethod($type)
 *
 * Class InputMaker
 * @package Luissobrinho\LCrud\Facades
 */
class InputMaker extends Facade
{
    /**
     * Create the Facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'InputMaker';
    }
}
