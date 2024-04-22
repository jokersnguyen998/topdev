<?php

namespace App\Http\Requests\Buyer_Seller;

use App\Enums\AdministrativeUnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBranchRequest extends FormRequest
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
            'name' => 'required|max:100',
            'phone_number' => 'nullable|digits:10,12',
            'detail_address' => 'nullable|max:255',
            'ward_id' => [
                'nullable',
                Rule::exists('administrative_units', 'id')->whereIn('type', AdministrativeUnitType::wards()),
            ],
        ];
    }
}
