<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('units')->insert([
            ['name' => 'Gram', 'conversion_factor' => 1, 'total_decimals' => 0, 'type' => 'weight', 'is_base_unit' => true],
            ['name' => 'Kilogram', 'conversion_factor' => 1000, 'total_decimals' => 2, 'type' => 'weight', 'is_base_unit' => false],
            ['name' => 'Milliliter', 'conversion_factor' => 1, 'total_decimals' => 0, 'type' => 'volume', 'is_base_unit' => true],
            ['name' => 'Liter', 'conversion_factor' => 1000, 'total_decimals' => 2, 'type' => 'volume', 'is_base_unit' => false],
        ]);
    }
}