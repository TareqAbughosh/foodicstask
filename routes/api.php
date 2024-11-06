<?php

use App\Http\Controllers\Api\Admin\IngredientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductsController::class, 'index']);

Route::post('order', [OrderController::class, 'store']);

Route::delete('orders/{id}', [OrderController::class, 'destroy']);

Route::put('admin/ingredients', [IngredientController::class, 'updateStock']);
