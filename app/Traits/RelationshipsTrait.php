<?php

namespace App\Traits;

use ErrorException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionMethod;

trait RelationshipsTrait
{
    public function relationships($relation = null)
    {
        $model = new static;

        $relationships = [];

        foreach ((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (
                $method->class != get_class($model) ||
                !empty($method->getParameters()) ||
                $method->getName() == __FUNCTION__
            ) {
                continue;
            }

            try {
                $return = $method->invoke($model);

                if ($return instanceof Relation) {
                    $relationships[$method->getName()] = [
                        'type' => (new ReflectionClass($return))->getShortName(),
                        'model' => (new ReflectionClass($return->getRelated()))->getName(),
                    ];
                }
            } catch (ErrorException $e) {
                // throw $e
            }
        }

        $relationships = array_filter(
            $relationships,
            fn ($item, $key) => is_null($relation) ? true : $key == $relation,
            ARRAY_FILTER_USE_BOTH
        );

        if (!is_null($relation) && count($relationships) === 0) {
            throw new \Exception("Method $relation not exists,");
        }

        return $relation ? Arr::flatten($relationships) : $relationships;
    }
}
