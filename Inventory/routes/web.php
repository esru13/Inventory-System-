<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessOwnerController;   
use App\Http\Controllers\ProductController;  
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\OrderController; 
Route::get('/', function () {
    return view('welcome');
});