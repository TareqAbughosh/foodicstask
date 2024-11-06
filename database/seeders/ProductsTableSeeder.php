<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            ['name' => 'Burger', 'price' => 100],
            ['name' => 'Pizza', 'price' => 150 ],
            ['name' => 'Salad', 'price' => 200],
        ]);
    }
}

