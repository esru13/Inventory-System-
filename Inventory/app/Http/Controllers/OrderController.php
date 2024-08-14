<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function placeOrder(OrderRequest $request)
    {
        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }

        $product->stock_quantity -= $request->quantity;
        $product->save();

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
        ]);

        return new OrderResource($order);
    }
}
