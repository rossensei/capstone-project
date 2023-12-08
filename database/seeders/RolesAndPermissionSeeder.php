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
        $office_head = Role::create(['name' => 'Office Head']);

        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'create-inventory']);
        Permission::create(['name' => 'edit-inventory']);
        Permission::create(['name' => 'delete-inventory']);

        Permission::create(['name' => 'view-transaction-history']);

        Permission::create(['name' => 'update-property-status']);

        $admin->givePermissionTo(Permission::all());
        $custodian->givePermissionTo(['create-inventory', 'edit-inventory', 'delete-inventory']);
        $office_head->givePermissionTo(['update-property-status', 'view-transaction-history']);

        // $users = User::all();

        // foreach($users as $user) {
        //     $user->assignRole('Department Head');
        // }

        $adminUser = User::create([
            'username' => 'rossensei',
            'name' => 'Rosalino Flores',
            'email' => 'fross0988@gmail.com',
            'address' => 'Pinayagan Sur, Tubigon, Bohol.',
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
    }
}
