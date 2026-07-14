<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perfume>
 */
class PerfumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(asText: true),
            'brand' => 'demo',
            'concentration' => $this->faker->randomElement(['EDP', 'EDT', 'Parfum']),
            'gender_target' =>  $this->faker->randomElement(['Masculine', 'Female']),
            'release_year' => $this->faker->numberBetween(1990, now()->year)
        ];
    }
}
