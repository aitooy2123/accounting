<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {

            Customer::create([
                'customer_code' => 'CUS' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Customer ' . $i,
                'phone' => '08' . rand(10000000,99999999),
                'email' => 'customer'.$i.'@example.com',
                'address' => 'Bangkok Thailand'
            ]);

        }
    }
}
