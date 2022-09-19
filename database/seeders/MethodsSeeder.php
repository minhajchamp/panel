<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dd = array(
            'Stripe' => 'stripe.png',
            'Paypal' => 'paypal.png',
            'Square Up' => 'square.png',
            'Payment Cloud' => 'pcloud.png'
        );
        foreach ($dd as $row => $key) {
            DB::table('payment_methods')->insert([
                'method_name' => $row,
                'method_type' => 1,
                'method_picture' => $key,
                'method_details' => '',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        }
    }
}
