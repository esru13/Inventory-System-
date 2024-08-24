<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessOwnerController;   
use App\Http\Controllers\ProductController;  
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\OrderController; 
Route::get('/', function () {
    return view('index');
});
Route::get('/user/register', function() {
    return view('register');
})->name('user.register');

Route::post('/user/register', [UserController::class, 'register']);
Route::get('/user/login', function() {
    return view('profile'); 
})->name('user.login');

Route::post('/user/login', [UserController::class, 'login']);

Route::get('/business-owner/register', function() {
    return view('business_owner.register'); 
})->name('business-owner.register');

Route::post('/business-owner/register', [BusinessOwnerController::class, 'register']);
Route::get('/business-owner/login', function() {
    return view('business_owner.login'); 
})->name('business-owner.login');

Route::post('/business-owner/login', [BusinessOwnerController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::post('/business-owner/logout', [BusinessOwnerController::class, 'logout']);

    Route::get('/product/create', function() {
        return view('product.create'); 
    })->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::get('/product/{id}/edit', function($id) {
        
        return view('product.edit', ['id' => $id]);
    })->name('product.edit');
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

    Route::get('/category/create', function() {
        return view('category.create'); // 
    })->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::get('/category/{id}/edit', function($id) {
        return view('category.edit', ['id' => $id]);
    })->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
    Route::post('/order', [OrderController::class, 'placeOrder']);
});