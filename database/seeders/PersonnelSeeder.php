<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = Office::all();

        foreach($offices as $office) {
            for($i=1; $i<=10; $i++) {
                $office->personnels()->create([
                    'name' => fake()->name,
                ]);
            }
        }
    }
}
