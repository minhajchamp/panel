<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'role_id' => 1,
            'email' => Str::random(10) . '@gmail.com',
            'user_contact' => "+923032323232",
            'user_country' => "Pakistan",
            'user_city' => "Karachi",
            'user_status' => 1,
            'password' => Hash::make('password'),
            'salt_password' => 'Helloworld',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);
    }
}
