<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Office;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Office::factory(100)->create();

        $users = User::all();

        foreach($users as $user) {
            $user->office()->create([
                'name' => fake()->word(),
                'date_added' => Carbon::today(),
            ]);
        }
    }
}
