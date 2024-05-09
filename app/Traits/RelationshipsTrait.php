<?php

namespace App\Traits;

use ErrorException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
            fn ($v, $k) => is_null($relation) ? true : $k === Str::camel($relation),
            ARRAY_FILTER_USE_BOTH
        );

        if (!is_null($relation) && count($relationships) === 0) {
            throw new \Exception("Method $relation not exists,");
        }

        return $relation ? Arr::flatten($relationships) : $relationships;
    }
}
