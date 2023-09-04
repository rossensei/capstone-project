<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'facility_name' => fake()->word(),
            'building' => fake()->randomElement(['Main Building', 'Main Building', 'SHS Building', 'Nursing Building', 'Elementary Building']),
            'user_id' => fake()->randomElement(range(1,20))
        ];
    }
}
