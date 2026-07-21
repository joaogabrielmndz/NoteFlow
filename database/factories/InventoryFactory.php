<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Perfume;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bottleSize = $this->faker->randomElement([50, 100, 200, 300]);

        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'perfume_id' => Perfume::inRandomOrder()->value('id') ?? Perfume::factory(),
            'status' => $this->faker->randomElement(['In use', 'Finished', 'Archived'])
        ];
    }
}
