<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Administrator']);
        $custodian = Role::create(['name' => 'Property Custodian']);
        $asset_manager = Role::create(['name' => 'Asset Manager']);

        Permission::create(['name' => 'manage-inventory']);
        
        Permission::create(['name' => 'manage-users']);

        Permission::create(['name' => 'update-property-status']);

        $admin->givePermissionTo(Permission::all());
        $custodian->givePermissionTo(['manage-inventory']);
        $asset_manager->givePermissionTo(['update-property-status']);

        $adminUser = User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'address' => 'Tubigon, Bohol',
            'password' => 'admin123',
        ]);

        $user1 = User::create([
            'username' => 'cymaejosol',
            'name' => 'Cymae Josol',
            'email' => 'temp_xyz@email.com',
            'address' => 'Pandan, Tubigon, Bohol.',
            'password' => 'password123',
        ]);

        $adminUser->assignRole('Administrator');
        $user1->assignRole('Property Custodian');

        \App\Models\User::factory(80)->create();

        $users = User::where('id', '!=', $adminUser->id)->get();

        foreach($users as $user) {
            $user->assignRole('Asset Manager');
        }
    }
}
