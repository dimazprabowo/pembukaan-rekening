<?php

namespace Database\Factories;

use App\Models\Rekening;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rekening>
 */
class RekeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Rekening::class;
    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tgl_lahir' => $this->faker->date(),
            'jk' => $this->faker->randomElement(['L', 'P']),
            'pekerjaan' => $this->faker->jobTitle(),
            'nominal' => $this->faker->numberBetween(1000000, 1000000000),
            'status' => $this->faker->randomElement(['approved', 'pending']),
        ];
    }
}
