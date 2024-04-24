<?php

namespace App\Http\Requests\Buyer;

use App\Enums\EmploymentType;
use App\Enums\LaborContractType;
use App\Enums\ReferralFeeType;
use App\Enums\SalaryType;
use App\Rules\PublishRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecruitmentRequest extends FormRequest
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
            'contact_branch_id' => [
                'required',
                Rule::exists('branches', 'id')->where('company_id', $this->user()->company_id),
            ],
            'contact_employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('company_id', $this->user()->company_id),
            ],
            'is_published' => [
                'required',
                'boolean',
                'published_with_all:publish_start_date,publish_end_date',
            ],
            'publish_start_date' => 'required|date_format:Y-m-d',
            'publish_end_date' => 'required|date_format:Y-m-d|after:publish_start_date',
            'title' => 'required|max:100',
            'sub_title' => 'required|max:100',
            'content' => 'required|max:800',
            'salary_type' => [
                'required',
                Rule::enum(SalaryType::class),
            ],
            'salary' => 'required|digits_between:7,10',
            'monthly_salary' => 'required|digits_between:7,10',
            'yearly_salary' => 'required|digits_between:7,10',
            'has_referral_fee' => 'required|boolean',
            'referral_fee_type' => [
                'nullable',
                Rule::enum(ReferralFeeType::class),
                Rule::requiredIf($this->has_referral_fee),
                Rule::prohibitedIf(!$this->has_referral_fee),
            ],
            'referral_fee_note' => [
                'nullable',
                'max:800',
                Rule::requiredIf($this->has_referral_fee),
            ],
            'referral_fee_by_value' => [
                'nullable',
                'digits_between:7,10',
                Rule::requiredIf($this->referral_fee_type === ReferralFeeType::MONEY->value),
                Rule::prohibitedIf($this->referral_fee_type !== ReferralFeeType::MONEY->value),
            ],
            'referral_fee_percent' => [
                'nullable',
                'digits_between:1,100',
                Rule::requiredIf($this->referral_fee_type === ReferralFeeType::PERCENT->value),
                Rule::prohibitedIf($this->referral_fee_type !== ReferralFeeType::PERCENT->value),
            ],
            'has_refund' => 'required|boolean',
            'refund_note' => [
                'nullable',
                'max:800',
                Rule::requiredIf($this->has_refund),
            ],
            'contact_email' => 'nullable|email|max:100',
            'contact_phone_number' => 'nullable|digits_between:10,12',
            'holiday' => 'nullable|max:800',
            'welfare' => 'nullable|max:800',
            'employment_type' => [
                'required',
                Rule::enum(EmploymentType::class),
            ],
            'employment_note' => 'nullable|max:800',
            'labor_contract_type' => [
                'required',
                Rule::enum(LaborContractType::class),
            ],
            'video_url' => 'nullable|url|max:255',
            'image_1_url' => 'nullable|url|max:255',
            'image_2_url' => 'nullable|url|max:255',
            'image_3_url' => 'nullable|url|max:255',
            'image_1_caption' => 'nullable|max:100',
            'image_2_caption' => 'nullable|max:100',
            'image_3_caption' => 'nullable|max:100',
        ];
    }
}
