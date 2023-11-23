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

        $list_permissions = [
            'read profile',
            'create profile',
            'edit profile',
            'create provider w9',
            'read provider w9',
            'download provider w9',
            'create provider payment',
            'read provider payment',
            'download provider payment',
            'read mrac_arac',
            'download mrac_arac',
            'notification management',
            'county users management',
            'activity management',
        ];

        $permissions_by_role = [
            'admin' => [
                'read profile',
                'create profile',
                'edit profile',
                'read provider w9',
                'download provider w9',
                'read provider payment',
                'download provider payment',
                'read mrac_arac',
                'download mrac_arac',
                'notification management',
                'county users management',
                'activity management',
            ],
            'manager' => [
                'read profile',
                'read provider w9',
                'download provider w9',
                'read provider payment',
                'download provider payment',
                'read mrac_arac',
                'download mrac_arac',
            ],
            'viewOnly' => [
                'read profile',
                'read provider w9',
                'read provider payment',
                'read mrac_arac',
            ],
            'countyUser' => [
                'read profile',
                'edit profile',
                'create provider w9',
                'read provider w9',
                'download provider w9',
                'create provider payment',
                'read provider payment',
                'download provider payment',
                'read mrac_arac',
                'download mrac_arac',
            ]
        ];

        foreach ($list_permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->givePermissionTo(
            'read profile',
            'create profile',
            'edit profile',
            'read provider w9',
            'download provider w9',
            'read provider payment',
            'download provider payment',
            'read mrac_arac',
            'download mrac_arac',
            'notification management',
            'county users management',
            'activity management');
        $managerRole->givePermissionTo(
            'read profile',
            'read provider w9',
            'download provider w9',
            'read provider payment',
            'download provider payment',
            'read mrac_arac',
            'download mrac_arac');
        $viewonlyRole ->givePermissionTo(
            'read profile',
            'read provider w9',
            'read provider payment',
            'read mrac_arac',
        );
        $countyuserRole ->givePermissionTo(
            'read profile',
            'edit profile',
            'create provider w9',
            'read provider w9',
            'create provider payment',
            'read provider payment',
            'read mrac_arac',
            );

        User::find(1)->assignRole('admin');
        User::find(2)->assignRole('manager');
        User::find(3)->assignRole('view only');
        User::find(4)->assignRole('county user');
    }
}