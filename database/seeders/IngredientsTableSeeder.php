<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredients')->insert([
            ['name' => 'Beef', 'stock' => 20000, 'initial_stock' => 20000, 'unit_id' => 2],
            ['name' => 'Cheese', 'stock' => 5000, 'initial_stock' => 5000, 'unit_id' => 2],
            ['name' => 'Onion', 'stock' => 1000, 'initial_stock' => 1000, 'unit_id' => 2],
            ['name' => 'Tomato', 'stock' => 3000, 'initial_stock' => 3000, 'unit_id' => 2],
            ['name' => 'Lettuce', 'stock' => 2000, 'initial_stock' => 2000, 'unit_id' => 2],
            ['name' => 'Dough', 'stock' => 5000, 'initial_stock' => 5000, 'unit_id' => 2],
            ['name' => 'Pepperoni', 'stock' => 1000, 'initial_stock' => 1000, 'unit_id' => 2],
        ]);
    }
}