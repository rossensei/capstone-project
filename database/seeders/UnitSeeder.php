<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'pieces',
                'abbreviation' => 'pcs',
            ],
            [
                'name' => 'reams',
                'abbreviation' => 'r',
            ],
            [
                'name' => 'boxes',
                'abbreviation' => 'bxs',
            ],
        ];

        foreach($units as $unit) {
            Unit::create($unit);
        }
    }
}
