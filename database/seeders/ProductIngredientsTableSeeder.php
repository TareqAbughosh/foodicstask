<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductIngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_ingredients')->insert([
            // Burger ingredients
            ['product_id' => 1, 'ingredient_id' => 1, 'unit_id' => 1, 'amount' => 150],
            ['product_id' => 1, 'ingredient_id' => 2, 'unit_id' => 1, 'amount' => 30],
            ['product_id' => 1, 'ingredient_id' => 3, 'unit_id' => 1, 'amount' => 20],

            // Pizza ingredients
            ['product_id' => 2, 'ingredient_id' => 6, 'unit_id' => 1, 'amount' => 200],
            ['product_id' => 2, 'ingredient_id' => 2, 'unit_id' => 1, 'amount' => 50],
            ['product_id' => 2, 'ingredient_id' => 7, 'unit_id' => 1, 'amount' => 30],
            ['product_id' => 2, 'ingredient_id' => 4, 'unit_id' => 1, 'amount' => 40],

            // Salad ingredients
            ['product_id' => 3, 'ingredient_id' => 4, 'unit_id' => 1, 'amount' => 50],
            ['product_id' => 3, 'ingredient_id' => 5, 'unit_id' => 1, 'amount' => 30],
            ['product_id' => 3, 'ingredient_id' => 3, 'unit_id' => 1, 'amount' => 10],
            ['product_id' => 3, 'ingredient_id' => 2, 'unit_id' => 1, 'amount' => 20],
        ]);
    }
}