<?php

namespace App\Http\Requests\Buyer_Seller;

use App\Enums\AdministrativeUnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
            'company_id' => 'required',
            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')
                    ->where('company_id', $this->user()->company_id),
            ],
            'ward_id' => [
                'nullable',
                Rule::exists('administrative_units', 'id')->whereIn('type', AdministrativeUnitType::wards()),
            ],
            'name'=> 'required|max:50',
            'email'=> 'required|email|max:100|unique:employees,email',
            'password'=> 'required|max:255',
            'phone_number'=> 'required|max:20',
            'gender'=> 'required|boolean',
            'birthday'=> 'required|date_format:Y-m-d',
            'detail_address'=> 'nullable|max:255',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'company_id' => $this->user()->company_id,
        ]);
    }
}
