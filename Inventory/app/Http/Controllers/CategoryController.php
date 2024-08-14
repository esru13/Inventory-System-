<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request){

        {
            // $user = auth()->user();
            try {
                $category = Category::create([
                    'name' => $request->name,
                ]);
                \Log::info('Prodcategoryuct created successfully', ['category' => $category]);
                return new CategoryResource($category);
            } catch (\Exception $e) {
                \Log::error('Error creating category', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Error creating Category', 'error' => $e->getMessage()], 500);
            }
        }
    }
    public function index()
    {
        $all = category::all();
        return response()->json($all);  
    }

    public function show($id)
    {
        try{
            $category = Category::findOrFail($id);
            return new CategoryResource($category);
        }
        catch (\Exception $e) {
            \Log::error('category not found', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'category not found', 'error' => $e->getMessage()], 500);
        }

    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return new CategoryResource($category);
    }

    public function destroy($id)
    { 
        try{ 

            $category = Category::findOrFail($id);
            // if ($category->business_owner_id !== auth()->user()->id) {
            // return response()->json(['message' => 'Unauthorized: Not your product'], 403);
            // }
            $category->delete();

            return response()->json(['message' => 'Product deleted successfully']);

        }
        catch (\Exception $e) {
            \Log::error('category not found', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'category not found', 'error' => $e->getMessage()], 500);
        }
        
    }


}
