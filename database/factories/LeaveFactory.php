<?php

namespace Database\Factories;

use App\Models\LeaveType;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $days = $this->faker->numberBetween(1, 5);
        $endDate = (clone $startDate)->modify('+' . ($days - 1) . ' days');

        return [
            'pegawai_id' => Pegawai::factory(),
            'leave_type_id' => LeaveType::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days_count' => $days,
            'alasan' => $this->faker->sentence(),
            'status' => 'pending',
        ];
    }
}
