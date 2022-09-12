<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('admin.home');
// })->middleware('auth');

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('category', CategoryController::class)->except(['create', 'show']);
Route::get('/category/destroy/{id}', [CategoryController::class, 'destroy']);
Route::post('/category/update/{id}',  [CategoryController::class, 'update']);
Route::resource('product', ProductController::class)->except(['create', 'show']);
Route::get('/product/destroy/{id}', [ProductController::class, 'destroy']);
Route::post('/product/update/{id}',  [ProductController::class, 'update']);
