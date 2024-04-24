<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;

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

// Export any file
Route::post('/export/csv', [ExportController::class, 'csv'])->name('export.csv');
Route::post('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
Route::post('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');

// Categories
Route::resource('depot/categories', CategoryController::class);
Route::put('depot/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');

// Products
Route::resource('depot/products', ProductController::class);
Route::put('depot/products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');

// Clients
Route::resource('sales/clients', ClientController::class);
Route::put('sales/clients/{client}/toggle', [ClientController::class, 'toggle'])->name('clients.toggle');

// Providers
Route::resource('shopping/providers', ProviderController::class);
Route::put('shopping/providers/{provider}/toggle', [ProviderController::class, 'toggle'])->name('providers.toggle');

// Incomes
Route::resource('shopping/incomes', IncomeController::class);
Route::put('shopping/incomes/{income}/toggle', [IncomeController::class, 'toggle'])->name('incomes.toggle');
