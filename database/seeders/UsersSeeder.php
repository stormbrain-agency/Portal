<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $admin_email = env('ADMIN_EMAIL', 'development@stormbrain.com');
        $admin_password = env('ADMIN_PASSWORD', 'W%JdE7EhM)TC!pS(imuAzEgw');
        $demoUser = User::create([
            'first_name'              => "CDA",
            'last_name'              => "Admin",
            'email'             => $admin_email,
            'password'          => Hash::make($admin_password),
            'status'          => 1,
            'email_verified_at' => now(),
        ]);

        $demoUser2 = User::create([
            'first_name'              => "CDA",
            'last_name'              => "Manage",
            'email'             => 'manager@demo.com',
            'password'          => Hash::make('demo'),
            'status'          => 1,
            'email_verified_at' => now(),
        ]);
        $demoUser3 = User::create([
            'first_name'              => "CDA",
            'last_name'              => "View Only",
            'email'             => 'viewonly@demo.com',
            'password'          => Hash::make('demo'),
            'status'          => 1,
            'email_verified_at' => now(),
        ]);
        $demoUser4 = User::create([
            'first_name'              => "Alex",
            'last_name'              => "Sandro",
            'business_phone'              => "1234567899",
            'mobile_phone'              => "033-561188",
            'mailing_address'              => "mail@gmail.com",
            'vendor_id'              => "9855-6665",
            'county_designation'              => "06037",
            'status'              => "9855-6665",
            'w9_file_path'              => "download.com",
            'email'             => 'countyuser@demo.com',
            'password'          => Hash::make('demo'),
            'status'          => 1,
            'email_verified_at' => now(),
        ]);
    }
}
