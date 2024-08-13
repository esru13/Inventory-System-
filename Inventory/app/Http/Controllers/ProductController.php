<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{

//     public function __construct()
//     {   
//     $this->middleware('auth:sanctum');
//     $this->middleware(function ($request, $next) {
//         $user = auth()->user();
//         if ($user) {
//             if ($user instanceof \App\Models\BusinessOwner) {
//                 return $next($request);
//             } else {
//                 return response()->json(['message' => 'Unauthorized: Not a BusinessOwner'], 403);
//             }
//         }
//         return response()->json(['message' => 'Unauthorized: No User'], 403);
//     })->only('store');
// }

    public function store(StoreProductRequest $request)
    {
        $user = auth()->user();
        if (!$user || !$user instanceof \App\Models\BusinessOwner) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = Product::create([
            'business_owner_id' => $user->id, 
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return new ProductResource($product);
    }

    public function index()
    {
        $all = Product::all();
        return response()->json($all);  
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->business_owner_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized: Not your product'], 403);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->business_owner_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized: Not your product'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

}