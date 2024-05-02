<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    use HasAdministrativeUnit;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();
        $isOnline = rand(0, 1);
        $startTime = $this->faker->dateTimeBetween('-2 months', '+2 weeks');
        return [
            'company_id' => $employee->company_id,
            'branch_id' => $employee->branch_id,
            'employee_id' => $employee->id,
            'ward_id' => $isOnline ? null : $this->wards()->inRandomOrder()->first('id')->id,
            'name' => $this->faker->streetName,
            'start_time' => $startTime,
            'end_time' => date_add($startTime, date_interval_create_from_date_string("1 hour")),
            'is_online' => $isOnline,
            'url' => $isOnline ? $this->faker->url : null,
            'detail_address' => $isOnline ? null : $this->faker->streetAddress,
        ];
    }
}
