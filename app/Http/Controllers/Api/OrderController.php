<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order,
        ], 201);
    }

    public function destroy($id)
    {
       $this->orderService->deleteOrder($id);

        return response()->json([
            'message' => 'Order deleted successfully.'
        ]);
    }
}
