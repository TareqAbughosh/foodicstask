<?php
namespace App\Services;

use App\Http\Resources\ProductsCollection;
use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        $products = Product::with('productIngredients.ingredient', 'productIngredients.unit')
            ->paginate(10);

        return new ProductsCollection($products);
    }
}
