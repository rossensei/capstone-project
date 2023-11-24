<?php

use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemApiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentInventoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'users' => User::count(),
        'facilities' => Department::count(),
        'items' => Item::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::get('/departments/{department}/inventory/view', [DepartmentController::class, 'show']);
    Route::get('/departments/details/{department}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::patch('/departments/{department}', [DepartmentController::class, 'update'])->name('department.update');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('department.store');
    Route::delete('/departments/remove-department/{department}', [DepartmentController::class, 'destroy'])->name('department.destroy');

    Route::get('/departments/{department}/inventory/edit', [DepartmentInventoryController::class, 'index']);
    Route::get('/departments/{department}/inventory/add-new', [DepartmentInventoryController::class, 'create']);
    Route::post('/departments/{department}/inventory', [DepartmentInventoryController::class, 'store']);
    Route::patch('/departments/{department}/inventory/{property}', [DepartmentInventoryController::class, 'update']);
    Route::patch('/departments/{department}/inventory/{property}/status-update', [DepartmentInventoryController::class, 'updateStatus']);
    Route::delete('/departments/{department}/inventory/{property}', [DepartmentInventoryController::class, 'deleteProperty']);
    // Route::post('/departments/{sourceDepartment}/inventory/{property}/move-property/{targetDepartment}', [DepartmentInventoryController::class, 'moveProperty']);
    // Route::get('/departments/{department}/inventory/edit', [PurchaseController::class, 'propertyForm']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::post('/users/toggle-active/{user}', [UserController::class, 'toggleActive']);
    Route::patch('/users/update-role/{user}', [UserController::class, 'updateRole'])->middleware('role:admin');
    Route::patch('/users/update-password/{user}', [UserController::class, 'updatePassword'])->middleware('role:admin');
    Route::delete('/users/delete/{user}', [UserController::class, 'destroy']);

    Route::get('/items', [ItemController::class, 'index'])->name('item.index');
    Route::get('/items/add-item', [ItemController::class, 'create'])->name('item.create');
    Route::get('/items/add-to-existing', [ItemController::class, 'createExisting']);
    Route::put('/items/add-to-existing/{item}', [ItemController::class, 'storeToExisting']);
    Route::post('/items', [ItemController::class, 'store'])->name('item.store');
    Route::get('/items/edit/{item}', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/items/delete-item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::delete('/items/delete-items', [ItemController::class, 'bulkDelete']);

    Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');

    // Route::get('/request-items', [FacultyRequestController::class, 'index']); //test endpoint


    Route::get('/new-purchased-item', [PurchaseController::class, 'itemForm']);
    Route::post('/store-item', [PurchaseController::class, 'storeItem']);
    Route::get('/new-purchased-property', [PurchaseController::class, 'propertyForm']);
    Route::post('/store-property', [PurchaseController::class, 'storeProperty']);


    // API Endpoints
    Route::get('/api/units', [ItemApiController::class, 'getUnits']);
    Route::get('/api/categories', [ItemApiController::class, 'getCategories']);
    Route::get('/api/items', [ItemApiController::class, 'getItems']);
    Route::get('/api/items/{item}', [ItemApiController::class, 'getItem']);

});

require __DIR__.'/auth.php';
