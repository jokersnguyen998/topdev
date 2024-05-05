<?php

namespace App\Http\Requests\Worker;

use App\Enums\AdministrativeUnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfoRequest extends FormRequest
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
            'ward_id' => [
                'required',
                Rule::exists('administrative_units', 'id')
                    ->where('type', AdministrativeUnitType::wards()),
            ],
            'contact_ward_id' => [
                'nullable',
                Rule::exists('administrative_units', 'id')
                    ->where('type', AdministrativeUnitType::wards()),
            ],
            'name' => 'nullable|max:50',
            'gender' => 'required|boolean',
            'birthday' => 'required|before:today|date_format:Y-m-d',
            'detail_address' => 'required|max:255',
            'avatar_url' => 'nullable|url|max:255',
            'contact_detail_address' => 'nullable|max:255',
            'contact_phone_number' => 'nullable|max:20',
        ];
    }
}
