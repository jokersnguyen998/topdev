<?php

namespace App\Http\Requests\Buyer;

class ImportRecruitmentValidator
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function make(array $data, array $rules, array $messages, array $attributes)
    {
        validator($data, $this->rules(), $messages, $attributes);
    }

    public function validate(): \Illuminate\Contracts\Validation\Factory|\Illuminate\Contracts\Validation\Validator
    {
        return validator($this->data, $this->rules());
    }

    private function rules(): array
    {
        return [];
    }

    private function messages(): array
    {
        return [];
    }

    private function attributes(): array
    {
        return [];
    }
}
