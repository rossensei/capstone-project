<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Personnel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'personnel_id' => mt_rand(1, 10),
            'date_time' => fake()->dateTime(),
            'remarks' => fake()->sentence(),
        ];
    }
}
