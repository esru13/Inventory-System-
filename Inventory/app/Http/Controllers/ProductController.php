<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BusinessOwner;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
    $user = auth()->user();

    $businessOwner = BusinessOwner::where('id', $user->id)->first();

    if (!$businessOwner) {
        return response()->json(['message' => 'Only business owners can post products.'], 403);
    }

    try {
        $product = Product::create([
            'business_owner_id' => $businessOwner->id, 
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id
        ]);

        return response()->json(['message' => 'Product created successfully', 'product' => new ProductResource($product)], 201);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error creating product', 'error' => $e->getMessage()], 500);
    }
}
    public function index()
    {
        $all = Product::all();
        return response()->json($all);  
    }

    public function show($id)
    {
        try{
            $product = Product::findOrFail($id);
            return new ProductResource($product);
        }
        catch (\Exception $e) {
            \Log::error('Product not found', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'product not found', 'error' => $e->getMessage()], 500);
        }

    }

    public function update(UpdateProductRequest $request, $id)
    {
        $user = auth()->user();

        $businessOwner = BusinessOwner::where('id', $user->id)->first();

        if (!$businessOwner) {
            return response()->json(['message' => 'Only business owners can post products.'], 403);
        }
        $product = Product::findOrFail($id);
        

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id
        ]);

        return new ProductResource($product);
    }

    public function destroy($id)
{
    try { 
        $user = auth()->user();

        $businessOwner = BusinessOwner::where('id', $user->id)->first();

        if (!$businessOwner) {
            return response()->json(['message' => 'Only business owners can delete products.'], 403);
        }

        $product = Product::findOrFail($id);

        if ($product->business_owner_id !== $businessOwner->id) {
            return response()->json(['message' => 'Unauthorized: Not your product'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);

        } catch (\Exception $e) {
            \Log::error('Error deleting product', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error deleting product', 'error' => $e->getMessage()], 500);
        }
}

}