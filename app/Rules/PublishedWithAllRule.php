<?php

namespace App\Rules;

class PublishedWithAllRule
{
    public function passes($attribute, $value, $parameters, $validator): bool
    {
        if (count($parameters) < 2) {
            throw new \InvalidArgumentException("Validation rule published_with_all requires 2 parameters.");
        }
        $now = now()->format('Y-m-d');
        $publishStartDate = data_get($validator->getData(), $parameters[0], null);
        $publishEndDate = data_get($validator->getData(), $parameters[1], null);

        $validator->addReplacer('published_with_all', 
            function($message, $attribute, $rule, $parameters) {
                return \str_replace(':custom_message', 'Invalid publication date.', $message);
            }
        );
        return $publishStartDate <= $now && $now <= $publishEndDate;
    }
}
