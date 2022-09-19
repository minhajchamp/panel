<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'brand_name' => Str::random(10),
            'brand_website' => "https://google.com",
            'brand_address' => Str::random(10) . '@gmail.com',
            'brand_contact' => "+923032323232",
            'brand_email' => "tesla@gmail.com",
            'brand_picture' => "",
            'brand_description' => "Lorem ipsum",
            'brand_status' => 1,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);
    }
}
