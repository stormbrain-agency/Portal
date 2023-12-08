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
        $admin_mobile_phone = env('ADMIN_MOBILE_PHONE', '5555555555');
        $demoUser = User::create([
            'first_name'              => "CDA",
            'last_name'              => "Admin",
            'email'             => $admin_email,
            'password'          => Hash::make($admin_password),
            'mobile_phone'          => $admin_mobile_phone,
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
            'mobile_phone'              => "1234567890",
            'mailing_address'              => "mail@gmail.com",
            'vendor_id'              => "9855-6665",
            'county_designation'              => "06037",
            'status'              => 1,
            'w9_file_path'              => "download.com",
            'email'             => 'countyuser@stormbrain.com',
            'password'          => Hash::make('Ws@@x5&M8JvTeBi'),
            'status'          => 1,
            'email_verified_at' => now(),
        ]);
        $demoUser5 = User::create([
            'first_name'              => "Demo",
            'last_name'              => "2FA",
            'business_phone'              => "1234567899",
            'mobile_phone'              => "7604520825",
            'mailing_address'              => "mail@gmail.com",
            'vendor_id'              => "9855-6665",
            'county_designation'              => "06037",
            'status'              => 1,
            'w9_file_path'              => "download.com",
            'email'             => 'test2fa@demo.com',
            'password'          => Hash::make('demo'),
            'status'          => 1,
            'email_verified_at' => now(),
        ]);
    }
}
