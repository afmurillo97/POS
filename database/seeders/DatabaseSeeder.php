<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Client;
use App\Models\Product;
use App\Models\Income;
use App\Models\Sale;
use App\Models\IncomeDetail;
use App\Models\SaleDetail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for each module
        $modules = ['Categories', 'Products', 'Providers', 'Clients', 'Incomes', 'Sales', 'Users', 'Roles', 'Permissions'];
        $actions = ['Create', 'Show', 'Edit', 'Delete', 'Export'];

        $permissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = $action . ' ' . $module;
            }
        }

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            // Categories permissions
            'Create Categories', 'Show Categories', 'Edit Categories', 'Delete Categories', 'Export Categories',
            // Products permissions
            'Create Products', 'Show Products', 'Edit Products', 'Delete Products', 'Export Products',
            // Providers permissions
            'Create Providers', 'Show Providers', 'Edit Providers', 'Delete Providers', 'Export Providers',
            // Clients permissions
            'Create Clients', 'Show Clients', 'Edit Clients', 'Delete Clients', 'Export Clients',
            // Incomes permissions
            'Create Incomes', 'Show Incomes', 'Edit Incomes', 'Delete Incomes', 'Export Incomes',
            // Sales permissions
            'Create Sales', 'Show Sales', 'Edit Sales', 'Delete Sales', 'Export Sales',
            // Users, Roles and Permissions (without Export)
            'Create Users', 'Show Users',
            'Create Roles', 'Show Roles',
            'Create Permissions', 'Show Permissions'
        ]);

        $cashierRole = Role::create(['name' => 'cashier']);
        $cashierRole->givePermissionTo([
            // Products permissions
            'Show Products', 'Export Products',
            // Clients permissions
            'Create Clients', 'Show Clients', 'Edit Clients', 'Export Clients',
            // Sales permissions
            'Create Sales', 'Show Sales', 'Edit Sales', 'Export Sales'
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'status' => 1
        ]);

        // Create manager user
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('manager123'),
            'status' => 1
        ]);

        // Create cashier user
        $cashier = User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@example.com',
            'password' => bcrypt('cashier123'),
            'status' => 1
        ]);

        // Assign roles after user creation
        $admin->role_id = $adminRole->id;
        $admin->save();
        $admin->assignRole('admin');

        $manager->role_id = $managerRole->id;
        $manager->save();
        $manager->assignRole('manager');

        $cashier->role_id = $cashierRole->id;
        $cashier->save();
        $cashier->assignRole('cashier');

        // Create categories with products
        $categories = [
            // 8 categories with 1-50 products each
            ['count' => 8, 'min_products' => 1, 'max_products' => 50],
            // 10 categories with 1-100 products each
            ['count' => 10, 'min_products' => 1, 'max_products' => 100],
            // 6 categories with 1-5 products each
            ['count' => 6, 'min_products' => 1, 'max_products' => 5]
        ];

        // Create all categories with their products
        $allCategories = collect();
        foreach ($categories as $categoryGroup) {
            $newCategories = Category::factory()
                ->count($categoryGroup['count'])
                ->has(
                    Product::factory()->count(random_int($categoryGroup['min_products'], $categoryGroup['max_products'])),
                    'products'
                )
                ->create();
            
            $allCategories = $allCategories->concat($newCategories);
        }

        // Get all products for use in incomes and sales
        $allProducts = $allCategories->flatMap->products;

        // Create providers
        $providers = Provider::factory()->count(20)->create();

        // Create clients
        $clients = Client::factory()->count(50)->create();

        // Create incomes with details
        for ($i = 0; $i < 30; $i++) {
            $income = Income::factory()->create([
                'provider_id' => $providers->random()->id
            ]);

            // Create 3 details for each income
            for ($j = 0; $j < 3; $j++) {
                $product = $allProducts->random();
                IncomeDetail::factory()->create([
                    'income_id' => $income->id,
                    'product_id' => $product->id,
                    'amount' => random_int(1, 10),
                    'purchase_price' => $product->purchase_price ?? random_int(10, 100),
                    'sale_price' => $product->sale_price ?? random_int(20, 200)
                ]);
            }
        }

        // Create sales with details
        for ($i = 0; $i < 50; $i++) {
            $sale = Sale::factory()->create([
                'client_id' => $clients->random()->id
            ]);

            // Create 3 details for each sale
            for ($j = 0; $j < 3; $j++) {
                $product = $allProducts->random();
                SaleDetail::factory()->create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'amount' => random_int(1, 10),
                    'sale_price' => $product->sale_price ?? random_int(20, 200)
                ]);
            }
        }
    }
}
