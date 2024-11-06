<?php

namespace App\Services;

use App\Models\Ingredient;
use Exception;

class IngredientService
{
    /**
     * Update the stock of multiple ingredients in bulk.
     *
     * @param  array  $ingredientsData
     * @return boolean
     * @throws \Exception
     */
    public function updateStockInBulk(array $ingredientsData)
    {
        $ingredientsIds = collect($ingredientsData['ingredients'])->pluck('id');
        $ingredients = Ingredient::whereIn('id', $ingredientsIds)->get();
        if(!count($ingredients)){
            abort(404);
        }
        foreach ($ingredients as $key => $ingredient) {
            $stockAmount = $ingredientsData['ingredients'][$key]['stock'];

            $ingredient->stock += $stockAmount;
            if($ingredient->stock >= $ingredient->initial_stock){
                $ingredient->initial_stock = $ingredient->stock;
            }
            $ingredient->save();
        }

        return true;
    }
}