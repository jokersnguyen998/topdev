<?php

namespace Database\Factories;

use App\Enums\EmploymentType;
use App\Enums\LaborContractType;
use App\Enums\ReferralFeeType;
use App\Enums\SalaryType;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recruitment>
 */
class RecruitmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::with('branch')->inRandomOrder()->first();
        $publishStartDate = $this->faker->dateTimeBetween('-2 months', 'now');
        $publishEndDate = $this->faker->dateTimeBetween('now', '+3 months');
        $isPublished = $publishStartDate <= now() && $publishEndDate >= now();
        $hasReferralFee = rand(0, 1);
        $referralFeeType = $hasReferralFee ? $this->faker->randomElement(ReferralFeeType::cases()) : null;
        $referralFeeValue = $referralFeeType === ReferralFeeType::MONEY ? rand(1_000_000, 10_000_000) : null;
        $referralFeePercent = $referralFeeType === ReferralFeeType::PERCENT ? rand(1, 100) : null;
        $salary = rand(10_000_000, 100_000_000);
        $referralFeeByPercent = $referralFeePercent ? ($referralFeePercent * $salary / 100) : null;
        $hasRefund = rand(0, 1);
        $title = $this->faker->jobTitle;
        return [
            'contact_branch_id' => $employee->branch_id,
            'contact_employee_id' => $employee->id,
            'is_published' => $isPublished,
            'publish_start_date' => $publishStartDate->format('Y-m-d'),
            'publish_end_date' => $publishEndDate->format('Y-m-d'),
            'number' => $this->faker->bothify('#?#?-####-????-?#?#'),
            'title' => $title,
            'sub_title' => $title,
            'content' => $this->faker->paragraph(1),
            'salary_type' => $this->faker->randomElement(SalaryType::cases()),
            'salary' => $salary,
            'monthly_salary' => rand(10_000_000, 100_000_000),
            'yearly_salary' => rand(10_000_000, 100_000_000),
            'has_referral_fee' => $hasReferralFee,
            'referral_fee_note' => $hasReferralFee ? $this->faker->paragraph(1) : null,
            'referral_fee_type' => $referralFeeType,
            'referral_fee_by_value' => $referralFeeValue,
            'referral_fee_percent' => $referralFeePercent,
            'referral_fee_by_percent' => $referralFeeByPercent,
            'has_refund' => $hasRefund,
            'refund_note' => $hasRefund ? $this->faker->paragraph(1) : null,
            'contact_email' => $this->faker->email,
            'contact_phone_number' => $this->faker->numerify('0#########'),
            'holiday' => $this->faker->paragraph(1),
            'welfare' => $this->faker->paragraph(1),
            'employment_type' => $this->faker->randomElement(EmploymentType::cases()),
            'employment_note' => $this->faker->paragraph(1),
            'labor_contract_type' => $this->faker->randomElement(LaborContractType::cases()),
            'video_url' => $this->faker->url,
            'image_1_url' => $this->faker->url,
            'image_2_url' => $this->faker->url,
            'image_3_url' => $this->faker->url,
            'image_1_caption' => $this->faker->sentence,
            'image_2_caption' => $this->faker->sentence,
            'image_3_caption' => $this->faker->sentence,
        ];
    }
}
