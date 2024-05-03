<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
            'work_summary' => 'nullable|max:500',
            'specialty' => 'nullable|max:500',
            'tools' => 'nullable|max:500',
            'self_promotion' => 'nullable|max:500',

            'job_careers.*.company_name' => 'required|max:100',
            'job_careers.*.department_name' => 'nullable|max:50',
            'job_careers.*.year' => 'required|integer',
            'job_careers.*.month' => 'required|min:1|max:12',
            'job_careers.*.is_retired' => 'required|boolean',
            'job_careers.*.environment' => 'nullable|max:500',
            'job_careers.*.role' => 'nullable|max:500',
            'job_careers.*.technique' => 'nullable|max:500',
        ];
    }
}
