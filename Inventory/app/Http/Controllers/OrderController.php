<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);

            if ($product->stock_quantity < $request->quantity) {
                return response()->json(['message' => 'Not enough stock available'], 400);
            }

            $totalPrice = $product->price * $request->quantity;

            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->user()->id, 
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
            ]);

            $product->update(['stock_quantity' => $product->stock_quantity - $request->quantity]);

            DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
        } catch (\Exception $e) {
       
            DB::rollBack();

            return response()->json(['message' => 'Failed to place order', 'error' => $e->getMessage()], 500);
        }
    }
}