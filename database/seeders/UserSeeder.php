<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Super Admin']);
        $permission = Permission::create(['name' => 'All Role']);

        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        $role2 = Role::create(['name' => 'Manager']);
        $permission2 = Permission::create(['name' => 'Create & Transaction']);

        $role2->givePermissionTo($permission2);
        $permission2->assignRole($role2);

        $role3 = Role::create(['name' => 'Employee']);
        $permission3 = Permission::create(['name' => 'Transaction']);

        $role3->givePermissionTo($permission3);
        $permission3->assignRole($role3);

        $users = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ]);
        $users->assignRole('Super Admin');
    }
}
