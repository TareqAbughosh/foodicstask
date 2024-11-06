<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{
    /**
     * Handle the order creation logic.
     * 
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data)
    {
        DB::beginTransaction();
    
        try {
            $productIds = collect($data['products'])->pluck('product_id');
    
            $products = Product::with('ingredients.unit')->whereIn('id', $productIds)->get();
    
            $productDict = $products->keyBy('id');
    
            $totalPrice = 0;
            $orderProducts = [];
    
            // Check stock levels for each product's ingredients before processing the order
            foreach ($data['products'] as $productData) {
                $productId = $productData['product_id'];
                $quantity = $productData['quantity'];
    
                $product = $productDict->get($productId);
    
                if (!$product) {
                    throw new ModelNotFoundException("Product with ID {$productId} not found.");
                }
    
                // Check the stock of each ingredient in the product
                foreach ($product->ingredients as $ingredient) {
                    $requiredAmount = $ingredient->pivot->amount * $quantity;
                    $availableStock = $ingredient->stock;
    
                    if ($availableStock < $requiredAmount) {
                        throw new \Exception("Not enough stock for ingredient {$ingredient->name}.");
                    }
                }
    
                $productTotalPrice = $product->price * $quantity;
                $totalPrice += $productTotalPrice;
    
                $orderProducts[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $productTotalPrice,
                ];
            }
    
            $order = Order::create([
                'status' => 'pending',
                'total_price' => $totalPrice,
            ]);
    
            foreach ($orderProducts as $op) {
                $orderProduct = new OrderProduct();
                $orderProduct->quantity = $op['quantity'];
                $orderProduct->price = $op['total_price'];
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $op['product_id'];
                $orderProduct->save();
            }
            $order->load('products');
    
            DB::commit();
    
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }    

    public function deleteOrder($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::where(['status' => 'pending', 'id' => $id])->first();
            if (!$order) {
                abort(404);
            }
            // to trigger the observer
            $orderProducts = OrderProduct::where('order_id', $order->id)->get();
            foreach ($orderProducts as $op) {
                $op->delete();
            }
            $order->delete();
            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
