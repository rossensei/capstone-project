<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Haruncpi\LaravelIdGenerator\IdGenerator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'office_id' => mt_rand(1, Department::count()),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'date_acquired' => Carbon::now()->format('Y-m-d')
        ];
    }
}
