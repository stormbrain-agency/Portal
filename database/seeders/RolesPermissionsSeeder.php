<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $viewonlyRole = Role::create(['name' => 'view only']);
        $countyuserRole = Role::create(['name' => 'county user']);
        $CDSSuserRole = Role::create(['name' => 'CDSS']);

        $list_permissions = [
            'read users management',
            'create users management',
            'edit users management',
            'create provider w9',
            'read provider w9',
            'download provider w9',
            'create provider payment',
            'template provider payment',
            'read provider payment',
            'download provider payment',
            'create mrac_arac',
            'read mrac_arac',
            'download mrac_arac',
            'template mrac_arac',
            'notification management',
            'county users management',
            'activity management',
        ];


        foreach ($list_permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->givePermissionTo(
            'read users management',
            'create users management',
            'edit users management',
            'read provider w9',
            'download provider w9',
            'template provider payment',
            'read provider payment',
            'download provider payment',
            'read mrac_arac',
            'template mrac_arac',
            'download mrac_arac',
            'notification management',
            'county users management',
            'activity management');
        $managerRole->givePermissionTo(
            'read users management',
            'read provider w9',
            'download provider w9',
            'read provider payment',
            'download provider payment',
            'read mrac_arac',
            'download mrac_arac');
        $viewonlyRole ->givePermissionTo(
            'read users management',
            'read provider w9',
            'read provider payment',
            'read mrac_arac',
        );
        $countyuserRole ->givePermissionTo(
            'create provider w9',
            'read provider w9',
            'create provider payment',
            'read provider payment',
            'create mrac_arac',
            'read mrac_arac',
        );

        $CDSSuserRole ->givePermissionTo(
            'create provider w9',
            'read provider w9',
            'create provider payment',
            'read provider payment',
            'create mrac_arac',
            'read mrac_arac',
        );

        User::find(1)->assignRole('admin');
        User::find(2)->assignRole('manager');
        User::find(3)->assignRole('view only');
        User::find(4)->assignRole('county user');
        User::find(5)->assignRole('county user');
    }
}