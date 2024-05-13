<?php

namespace App\Http\Requests\Buyer;

use App\Enums\AdministrativeUnitType;
use App\Enums\EmploymentType;
use App\Enums\LaborContractType;
use App\Enums\ReferralFeeType;
use App\Enums\SalaryType;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;

class ImportRecruitmentValidator
{
    public Factory|Validator $validator;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = validator($this->data, $this->rules(), $this->messages(), $this->attributes());
    }

    public function validate(): array
    {
        return $this->validator->validate();
    }

    private function rules(): array
    {
        return [
            '*.contact_branch_id' => [
                'required',
                Rule::exists('branches', 'id')
                    ->where('company_id', request()->user()->company_id),
            ],
            '*.contact_employee_id' => [
                'required',
                Rule::exists('employees', 'id')
                    ->where('company_id', request()->user()->company_id),
            ],
            '*.is_published' => [
                'required',
                'boolean',
                'published_with_all:publish_start_date,publish_end_date',
            ],
            '*.publish_start_date' => 'required|date_format:Y-m-d',
            '*.publish_end_date' => 'required|date_format:Y-m-d|after:publish_start_date',
            '*.number' => [
                'required',
                'max:50',
            ],
            '*.title' => 'required|max:100',
            '*.sub_title' => 'required|max:100',
            '*.content' => 'required|max:800',
            '*.salary_type' => [
                'required',
                Rule::enum(SalaryType::class),
            ],
            '*.salary' => 'required|digits_between:7,10',
            '*.monthly_salary' => 'required|digits_between:7,10',
            '*.yearly_salary' => 'required|digits_between:7,10',
            '*.has_referral_fee' => 'required|boolean',
            '*.referral_fee_type' => Rule::forEach(function (string|null $value, string $attribute) {
                $key = explode('.', $attribute);
                return [
                    'nullable',
                    Rule::enum(ReferralFeeType::class),
                    Rule::requiredIf(!!$this->data[$key[0]]['has_referral_fee']),
                    Rule::prohibitedIf(!$this->data[$key[0]]['has_referral_fee']),
                ];
            }),
            // '*.referral_fee_note' => [
            //     'nullable',
            //     'max:800',
            //     'required_if:*.has_referral_fee,true',
            //     // Rule::requiredIf($data['has_referral_fee']),
            // ],
            // '*.referral_fee_by_value' => [
            //     'nullable',
            //     'digits_between:7,10',
            //     // Rule::requiredIf(fn ($value) => dd($value['referral_fee_type'])),
            //     Rule::requiredIf(fn ($value) => $value['referral_fee_type'] === ReferralFeeType::MONEY->value),
            //     Rule::prohibitedIf(fn ($value) => $value['referral_fee_type'] !== ReferralFeeType::MONEY->value),
            // ],
            // '*.referral_fee_percent' => [
            //     'nullable',
            //     'digits_between:1,100',
            //     Rule::requiredIf(fn ($value) => $value['referral_fee_type'] === ReferralFeeType::PERCENT->value),
            //     Rule::prohibitedIf(fn ($value) => $value['referral_fee_type'] !== ReferralFeeType::PERCENT->value),
            // ],
            // '*.has_refund' => 'required|boolean',
            // '*.refund_note' => [
            //     'nullable',
            //     'max:800',
            //     Rule::requiredIf(fn ($value) => $value['has_refund']),
            // ],
            '*.contact_email' => 'nullable|email|max:100',
            '*.contact_phone_number' => 'nullable|digits_between:10,12',
            '*.holiday' => 'nullable|max:800',
            '*.welfare' => 'nullable|max:800',
            '*.employment_type' => [
                'required',
                Rule::enum(EmploymentType::class),
            ],
            '*.employment_note' => 'nullable|max:800',
            '*.labor_contract_type' => [
                'required',
                Rule::enum(LaborContractType::class),
            ],
            '*.video_url' => 'nullable|url|max:255',
            '*.image_1_url' => 'nullable|url|max:255',
            '*.image_2_url' => 'nullable|url|max:255',
            '*.image_3_url' => 'nullable|url|max:255',
            '*.image_1_caption' => 'nullable|max:100',
            '*.image_2_caption' => 'nullable|max:100',
            '*.image_3_caption' => 'nullable|max:100',

            '*.recruitment_occupations.*' => 'nullable|exists:occupations,id',

            '*.working_locations.*' => 'nullable|array',
            '*.working_locations.*.ward_id' => [
                'required',
                Rule::exists('administrative_units', 'id')
                    ->whereIn('type', AdministrativeUnitType::wards()),
            ],
            '*.working_locations.*.detail_address' => 'required|max:255',
            '*.working_locations.*.map_url' => 'nullable|max:255',
            '*.working_locations.*.note' => 'nullable|max:500',
        ];
    }

    private function messages(): array
    {
        return [];
    }

    private function attributes(): array
    {
        return [];
    }

    private function requiredIf($attribute, $value, $fail, $targetKey)
    {
        $key = explode('.', $attribute);
        $condition = Rule::requiredIf(isset($this->data[$key[0]][$targetKey]))->condition;
        if (is_null($value) && $condition) {
            $fail("21312");
        }
    }
    
    private function prohibitedIf($attribute, $targetKey)
    {
        $key = explode('.', $attribute);
        return Rule::prohibitedIf(!isset($this->data[$key[0]][$targetKey]));
    }
}
