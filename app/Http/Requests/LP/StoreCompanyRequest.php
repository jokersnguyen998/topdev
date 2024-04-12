<?php

namespace App\Http\Requests\LP;

use App\Enums\AdministrativeUnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
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
                'nullable',
                Rule::exists('administrative_units', 'id')
                    ->whereIn('type', AdministrativeUnitType::wards())
            ],
            'name' => 'required|max:100',
            'representative' => 'nullable|max:50',
            'detail_address' => 'nullable|max:255',
            'phone_number' => 'nullable|max:20',
            'homepage_url' => 'nullable|max:255',
            'contact_person' => 'required|max:50',
            'contact_email' => 'required|email|max:100|unique:companies,contact_email',
            'contact_phone_number' => 'required|max:20',
        ];
    }
}
