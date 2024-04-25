<?php

namespace App\Rules;

use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class PublishedWithAllRule
{
    /**
     * Validate input data
     *
     * @param  string    $attribute
     * @param  mixed     $value
     * @param  array     $parameters
     * @param  Validator $validator
     * @return bool
     */
    public function passes(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        if (!$value) return true;

        $this->sureValidArgument($parameters);

        $startDate = Carbon::parse(data_get($validator->getData(), $parameters[0]))
            ->setTime(0, 0, 0, 0);
        $endDate = Carbon::parse(data_get($validator->getData(), $parameters[1]))
            ->setTime(0, 0, 0, 0);

        $validator->addReplacer(
            'published_with_all',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace(
                    ':message',
                    "The start and end dates of the recruitment are invalid.",
                    $message
                );
            }
        );

        return $startDate->lte(today()) && $endDate->gte(today());
    }

    /**
     * Undocumented function
     *
     * @param  array $parameters
     * @return void
     *
     * @throws \InvalidArgumentException

     */
    private function sureValidArgument(array $parameters): void
    {
        if (!isset($parameters[1])) {
            throw new \InvalidArgumentException("Validation rule published_with_all requires the start date and end date to be passed.");
        }
    }
}
