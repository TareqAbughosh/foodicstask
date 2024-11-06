<?php

namespace App\Observers;

namespace App\Observers;

use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Ingredient;

class OrderProductObserver
{
    public function created(OrderProduct $orderProduct)
    {
        $orderProduct = $orderProduct->load('product.ingredients.unit');

        foreach ($orderProduct->product->ingredients as $ingredient) {
            $this->decreaseIngredientStock($ingredient, $ingredient->pivot->amount, $ingredient->unit, $orderProduct->quantity);
        }
    }

    public function deleted(OrderProduct $orderProduct)
    {
        $orderProduct = $orderProduct->load('product.ingredients.unit');

        foreach ($orderProduct->product->ingredients as $ingredient) {
            $this->increaseIngredientStock($ingredient, $ingredient->pivot->amount, $ingredient->unit, $orderProduct->quantity);
        }
    }

    /**
     * Decrease the stock of an ingredient based on the order quantity.
     *
     * @param \App\Models\Ingredient $ingredient
     * @param float $amountPerProduct
     * @param \App\Models\Unit $productUnit
     * @param int $orderQuantity
     * @return void
     */
    protected function decreaseIngredientStock(Ingredient $ingredient, $amountPerProduct, $productUnit, int $orderQuantity)
    {
        $amountUsed = $amountPerProduct * $orderQuantity;
        $convertedAmount = $this->convertToStockUnit($amountUsed, $productUnit, $ingredient->unit);

        $ingredient->stock -= $convertedAmount;
        $ingredient->save();
    }


    /**
     * Increase the stock of the ingredient in case of order cancellation.
     *
     * @param \App\Models\Ingredient $ingredient
     * @param float $amountPerProduct
     * @param \App\Models\Unit $productUnit
     * @param int $orderQuantity
     * @return void
     */
    protected function increaseIngredientStock(Ingredient $ingredient, $amountPerProduct, $productUnit, int $orderQuantity)
    {
        $amountUsed = $amountPerProduct * $orderQuantity;

        $convertedAmount = $this->convertToStockUnit($amountUsed, $productUnit, $ingredient->unit);

        $ingredient->stock += $convertedAmount;
        $ingredient->save();
    }

    /**
     * Convert ingredient amount to stock unit based on the unit conversion.
     *
     * @param float $amount
     * @param \App\Models\Unit $ingredientUnit
     * @param \App\Models\Unit $stockUnit
     * @return float
     */
    protected function convertToStockUnit($amount, $ingredientUnit, $stockUnit)
    {
        if ($ingredientUnit->unit_id === $stockUnit->id) {
            return $amount;
        }

        if ($ingredientUnit->conversion_factor > $stockUnit->conversion_factor) {
            return $amount / ($ingredientUnit->conversion_factor / $stockUnit->conversion_factor);
        }

        return $amount * ($stockUnit->conversion_factor / $ingredientUnit->conversion_factor);
    }
}
