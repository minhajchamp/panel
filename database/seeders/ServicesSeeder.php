<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'service_name' => Str::random(10),
            'service_type' => "Serve",
            'service_picture' => '',
            'service_description' => "Lorem ipsum..",
            'service_status' => 1,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);
        $last_id = DB::getPdo()->lastInsertId();
        DB::table('brands_services')->insert([
            'service_id' => $last_id,
            'brand_id' => 1,
        ]);
    }
}
