<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'ingredients' => $product->productIngredients->transform(function ($productIngredient) {
                        return [
                            'ingredient_name' => $productIngredient->ingredient->name,
                            'amount' => $productIngredient->amount,
                            'unit' => $productIngredient->unit->name,
                        ];
                    }),
                ];
            }),
            'pagination' => [
                'total' => $this->resource->total(),
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'next_page_url' => $this->resource->nextPageUrl(),
                'prev_page_url' => $this->resource->previousPageUrl(),
            ],
        ];
    }
}

