<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingCitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            ['city_name' => 'Semarang', 'shipping_cost' => 0],
            ['city_name' => 'Jakarta', 'shipping_cost' => 25000],
            ['city_name' => 'Bandung', 'shipping_cost' => 22000],
            ['city_name' => 'Surabaya', 'shipping_cost' => 27000],
            ['city_name' => 'Yogyakarta', 'shipping_cost' => 20000],
        ];

        DB::table('shipping_cities')->insert($cities);
    }
}
