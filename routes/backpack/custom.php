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
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { 
    // Apply role-based restriction inside the group
    Route::middleware(['role:' . RolesEnum::Admin->value . '|' . RolesEnum::Vendor->value])
        ->group(function () {
            // Place your Backpack routes here
            Route::get('/', function () {
                return redirect()->route('backpack.dashboard');
            })->name('admin.dashboard');

            // 🔹 Backpack Authentication Routes
            // Route::get('/login', 'App\Http\Controllers\Admin\AuthController@showLoginForm')->name('admin.login');
            // Route::post('/login', 'App\Http\Controllers\Admin\AuthController@login');
            // Route::post('/logout', 'App\Http\Controllers\Admin\AuthController@logout')->name('admin.logout');

          
        });
    });