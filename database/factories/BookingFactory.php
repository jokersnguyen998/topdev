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
    public function definition() : array
    {
        return [
            'company_id' => fn ($booking) => Employee::find($booking['employee_id'])->company_id,
            'branch_id' => fn ($booking) => Employee::find($booking['employee_id'])->branch_id,
            'employee_id' => Employee::factory(),
            'ward_id' => fn ($booking) => ! $booking['is_online'] ? $this->wards()->inRandomOrder()->first('id')->id : null,
            'name' => $this->faker->streetName,
            'start_time' => $this->faker->dateTimeBetween('-2 months', '+2 weeks'),
            'end_time' => fn ($booking) => date_add($booking['start_time'], date_interval_create_from_date_string("1 hour")),
            'is_online' => rand(0, 1),
            'url' => fn ($booking) => $booking['is_online'] ? $this->faker->url : null,
            'detail_address' => fn ($booking) => ! $booking['is_online'] ? $this->faker->streetAddress : null,
        ];
    }
}
