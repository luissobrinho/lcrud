<?php

namespace Luissobrinho\LCrud\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method setConnection(string $connection)
 * @method setColumns(int $columns)
 * @method fromTable(string $table, array $columns, string $class, string $view, bool $reformatted, bool $populated, bool $idAndTimestamps)
 * @method fromArray(array  $array, array $columns, string $view, string $class, bool $populated, bool $reformatted, bool $timestamps)
 * @method fromObject(object $object, array $columns, string $view, string $class, bool $populated, bool $reformatted, bool $timestamps)
 * @method cleanupIdAndTimeStamps(array $collection, bool $timestamps, bool $id)
 * @method getFormErrors()
 * @method formContentBuild(array $field, string $column, string $input, string $errorMessage)
 * @method getTableColumns(string $table, bool $allColumns)
 * Class LForm
 * @package Luissobrinho\LCrud\Facades
 */
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
