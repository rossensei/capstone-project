<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory()->create();

        $categories = [
            [
                'name' => 'Elementary Uniforms',
            ],
            [
                'name' => 'Senior High School Uniforms',
            ],
            [
                'name' => 'College Uniforms',
            ],
            [
                'name' => 'School Supplies',
            ],
            [
                'name' => 'Equipment',
            ],
            [
                'name' => 'Furniture',
            ],
        ];

        foreach($categories as $cat) {
            Category::create($cat);
        }
    }
}
