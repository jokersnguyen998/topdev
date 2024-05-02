<?php

namespace App\Http\Requests\Buyer;

use App\Enums\AdministrativeUnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMeetingRoomRequest extends FormRequest
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
                Rule::requiredIf($this->is_online == false),
                Rule::prohibitedIf($this->is_online == true),
                Rule::exists('administrative_units', 'id')
                    ->where('type', AdministrativeUnitType::wards()),
            ],
            'name' => 'required|max:50',
            'is_online' => 'required|boolean',
            'url' => [
                'nullable',
                'max:255',
                Rule::requiredIf($this->is_online == true),
                Rule::prohibitedIf($this->is_online == false),
            ],
            'detail_address' => [
                'nullable',
                'max:255',
                Rule::requiredIf($this->is_online == false),
                Rule::prohibitedIf($this->is_online == true),
            ],
        ];
    }
}
