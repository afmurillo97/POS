<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Auth;

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

// Authentication
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Security
    Route::resource('security/roles', RoleController::class);
    Route::resource('security/permissions', PermissionController::class);
    Route::resource('security/users', UserController::class);
    Route::put('security/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');

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

    // Sales
    Route::resource('sales/sales', SaleController::class);
    Route::put('sales/sales/{sale}/toggle', [SaleController::class, 'toggle'])->name('sales.toggle');
});