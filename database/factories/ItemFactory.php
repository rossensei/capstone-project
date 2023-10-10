<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'category_id' => fake()->randomElement(range(1,4)),
            'qty' => fake()->randomNumber(4, false),
            'unit_id' => fake()->randomElement(range(1,3)),
            'size' => fake()->randomElement([null, null, null, 'Long', 'Short', 'Small', 'Medium', 'Large', 'Extra Large']),
        ];
    }
}
