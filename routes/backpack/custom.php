<?php

use App\RolesEnum;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        ['auth'] // Ensure the user is authenticated
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    // Dashboard: Accessible by both Admin and Vendor
    Route::middleware(['role:' . RolesEnum::Admin->value . '|' . RolesEnum::Vendor->value])
        ->group(function () {
            Route::get('/', function () {
                return redirect()->route('backpack.dashboard');
            })->name('admin.dashboard');
        });

    // Admin-Only Routes: Only Admin users can access these CRUD routes.
    Route::middleware(['role:' . RolesEnum::Admin->value])
        ->group(function () {
            Route::crud('department', 'DepartmentCrudController');
            Route::crud('category', 'CategoryCrudController'); // Only Admin now
        });

    // Vendor-Only Routes: Only Vendor users can access these CRUD routes.
    Route::middleware(['role:' . RolesEnum::Vendor->value])
        ->group(function () {
            Route::crud('product', 'ProductCrudController');

            // You can add more vendor-specific routes here.
        });

    // Optionally, add routes for regular users if needed:
    Route::middleware(['role:' . RolesEnum::User->value])
        ->group(function () {
            // Define user-specific routes here.
        });
});
