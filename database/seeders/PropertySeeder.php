<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = Office::all();

        foreach($offices as $office) {
            for($i=1; $i<=100; $i++) {
                $office->properties()->create([
                    'name' => fake()->word(),
                    'description' => fake()->sentence(),
                    'date_acquired' => Carbon::now()->format('Y-m-d')
                ]);
            }
        }
    }
}
