<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessOwnerController;   
use App\Http\Controllers\ProductController;  
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\OrderController; 

Route::get('/', function() {
    return response()->json('Welcome to Inventory System');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::post('/business-owner/register', [BusinessOwnerController::class, 'register']);
Route::post('/business-owner/login', [BusinessOwnerController::class, 'login']);

Route::get('/products',[ProductController::class ,'index']);
Route::get('/categories',[CategoryController::class ,'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/logout',[UserController::class, 'logout']);
    Route::post('/business-owner/logout',[BusinessOwnerController::class, 'logout']);
    Route::post('/product/store',[ProductController::class, 'store']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
    Route::post('/category/store',[CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
    Route::post('/order', [OrderController::class, 'store']);
});