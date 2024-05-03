<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class AcademicLevelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.year' => 'nullable|integer',
            '*.month' => 'nullable|integer|min:1|max:12',
            '*.content' => 'required|max:255',
        ];
    }
}
