<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'client']);
        $role = Role::create(['name' => 'users']);
        $modules = array('brands', 'leads', 'settings', 'payments');
        foreach ($modules as $row) :
            $permission1 = Permission::create(['name' => 'edit '.$row]);
            $permission2 = Permission::create(['name' => 'add '.$row]);
            $permission3 = Permission::create(['name' => 'remove '.$row]);
            $permission4 = Permission::create(['name' => 'list '.$row]);
        endforeach;
        $role->givePermissionTo([$permission1, $permission2, $permission3, $permission4]);
        // $role->assignRole($role);
    }
}
