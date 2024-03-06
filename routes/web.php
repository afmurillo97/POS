<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('depot/categories', CategoryController::class);

Route::resource('depot/products', ProductController::class);
Route::put('depot/products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');
Route::post('/products/export', [ProductController::class, 'export'])->name('products.export');

