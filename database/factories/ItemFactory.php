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
            'facility_id' => fake()->randomElement(range(1,20)),
            'tag_no' => fake()->randomNumber(5, true),
            'serial_no' => fake()->isbn10(),
            'item_name' => fake()->word(),
            'description' => fake()->sentence(),
            'condition' => fake()->randomElement(['Good', 'Good', 'Damaged', 'New', 'Used']),
            'date_acquired' => fake()->date(),
        ];
    }
}
