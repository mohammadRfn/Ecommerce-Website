<?php 

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Profile routes for the user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin-Only Routes (Backpack CRUD - No Duplicate Naming)
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::group([
        'prefix' => config('backpack.base.route_prefix', 'admin'),
        'middleware' => array_merge(
            (array) config('backpack.base.web_middleware', 'web'),
            (array) config('backpack.base.middleware_key', 'admin')
        ),
        'namespace' => 'App\Http\Controllers\Admin',
    ], function () {
        Route::crud('department', 'DepartmentCrudController'); // Admins can manage departments
        Route::crud('category', 'CategoryCrudController');
    });
});

//Vendor-Only Routes (Backpack CRUD - No Duplicate Naming)
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::group([
        'prefix' => config('backpack.base.route_prefix', 'admin'),
        'middleware' => array_merge(
            (array) config('backpack.base.web_middleware', 'web'),
            (array) config('backpack.base.middleware_key', 'admin')
        ),
        'namespace' => 'App\Http\Controllers\Admin',
    ], function () {
        Route::crud('product', 'ProductCrudController');
         // Vendors can manage categories
    });
});
// Load auth routes
require __DIR__.'/auth.php';
