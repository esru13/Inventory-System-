<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    public function store(StoreProductRequest $request)
    {
        $user = auth()->user();
        try {
            $product = Product::create([
                'business_owner_id' => $user->id, 
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'category_id' => $request->category_id
            ]);
            \Log::info('Product created successfully', ['product' => $product]);
            return new ProductResource($product);
        } catch (\Exception $e) {
            \Log::error('Error creating product', ['error' => $e->getMessage()]);
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
       

        try{ 
            
            $product = Product::findOrFail($id);
            if ($product->business_owner_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized: Not your product'], 403);
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);

        }
        catch (\Exception $e) {
            \Log::error('Product not found', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'product not found', 'error' => $e->getMessage()], 500);
        }
        
    }

}