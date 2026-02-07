<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'jabatan_id' => Jabatan::factory(),
            'employee_id' => 'EMP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'nama_pegawai' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('################'),
            'tanggal_lahir' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'tanggal_masuk' => $this->faker->date(),
            'status' => 'aktif',
            'gaji_pokok' => $this->faker->numberBetween(3000000, 10000000),
            'image' => 'default.jpg',
        ];
    }
}
