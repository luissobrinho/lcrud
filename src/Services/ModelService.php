<?php

namespace Luissobrinho\LCrud\Services;

use Illuminate\Support\Str;

class ModelService
{
    protected $tableService;

    public function __construct()
    {
        $this->tableService = new TableService();
    }

    /**
     * Prepare a models relationships.
     *
     * @param array $relationships
     *
     * @return string
     */
    public function prepareModelRelationships($relationships)
    {
        $relationshipMethods = '';

        foreach ($relationships as $relation) {
            if (!isset($relation[2])) {
                $relationEnd = explode('\\', $relation[1]);
                $relation[2] = strtolower(end($relationEnd));
            }

            $method = Str::singular($relation[2]);

            if (stristr($relation[0], 'many')) {
                $method = Str::plural($relation[2]);
            }

            $relationshipMethods .= "\n\tpublic function ".$method.'() {';
            $relationshipMethods .= "\n\t\treturn \$this->$relation[0]($relation[1]::class);";
            $relationshipMethods .= "\n\t}\n\t";
        }

        return $relationshipMethods;
    }

    /**
     * Configure the model.
     *
     * @param array  $config
     * @param string $model
     *
     * @return string
     */
    public function configTheModel($config, $model)
    {
        if (!empty($config['schema'])) {
            $model = str_replace('// _Str::camel_ table data', $this->tableService->prepareTableDefinition($config['schema']), $model);
        }

        if (!empty($config['relationships'])) {
            $relationships = [];

            foreach (explode(',', $config['relationships']) as $relationshipExpression) {
                $relationships[] = explode('|', $relationshipExpression);
            }

            $model = str_replace('// _Str::camel_ relationships', $this->prepareModelRelationships($relationships), $model);
        }

        return $model;
    }
}
