<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientStockUpdateRequest;
use App\Services\IngredientService;
use Illuminate\Http\Request;

class IngredientController extends Controller
{

    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function updateStock(IngredientStockUpdateRequest $request)
    {
        $this->ingredientService->updateStockInBulk($request->validated());

        return response()->json([
            'message' => 'Ingredients have been updated'
        ]);
    }
}
