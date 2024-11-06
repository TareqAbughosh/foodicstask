<?php

namespace App\Observers;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;

class IngredientObserver
{
    public function updated(Ingredient $ingredient)
    {
        if ($ingredient->isDirty('stock')) {
            $halfStockLevel = $ingredient->initial_stock / 2;

            if ($ingredient->stock <= $halfStockLevel && !$ingredient->warning_email_sent) {
                // Send a fake email for testing purposes
                $this->sendLowStockEmail($ingredient);

                $ingredient->warning_email_sent = true;
                $ingredient->save();
            }

            if ($ingredient->stock > $halfStockLevel && $ingredient->warning_email_sent) {
                $ingredient->warning_email_sent = false;
                $ingredient->save();
            }
        }
    }

    /**
     * Send a low stock warning email.
     * This is just for testing purposes, for an actual email, we will be using a background job to do that.
     * @param \App\Models\Ingredient $ingredient
     * @return void
     */
    protected function sendLowStockEmail(Ingredient $ingredient)
    {
        Mail::raw("Warning: Ingredient {$ingredient->name} stock is below 50%.", function ($message) {
            $message->to('merchant@foodics.com')
                    ->subject('Low Ingredient Stock Warning');
        });
    }
}

