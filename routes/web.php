<?php

use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Office;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ItemApiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\OfficeApiController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PropertyApiController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PersonnelApiController;
use App\Http\Controllers\DepartmentApiController;
use App\Http\Controllers\OfficeInventoryController;
use App\Http\Controllers\HandleFlashMessageController;
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
        'offices' => Office::count(),
        'items' => Item::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/offices', [OfficeController::class, 'index'])->name('office.index');
    // Route::get('/offices/create', [OfficeController::class, 'create'])->name('office.create');
    Route::get('/admin/offices/{office}/inventory/view', [OfficeController::class, 'show']);
    // Route::get('/admin/offices/details/{office}/edit', [OfficeController::class, 'edit'])->name('office.edit');
    Route::patch('/admin/offices/{office}', [OfficeController::class, 'update'])->name('office.update');
    Route::post('/admin/offices', [OfficeController::class, 'store'])->name('office.store');
    Route::delete('/admin/offices/remove-office/{office}', [OfficeController::class, 'destroy'])->name('office.destroy');

    Route::get('/admin/offices/{office}/inventory', [OfficeInventoryController::class, 'index']);
    // Route::get('/offices/{department}/inventory/add-new', [OfficeInventoryController::class, 'create']);
    Route::post('/admin/offices/{office}/inventory', [OfficeInventoryController::class, 'store']);
    Route::patch('/admin/offices/{office}/inventory/{property}', [OfficeInventoryController::class, 'update']);
    Route::patch('/admin/offices/{office}/inventory/{property}/status-update', [OfficeInventoryController::class, 'updateStatus']);
    Route::delete('/admin/offices/{office}/inventory/{property}', [OfficeInventoryController::class, 'deleteProperty']);

    // Personnels
    Route::get('/admin/personnels', [PersonnelController::class, 'index']);
    Route::post('/admin/personnels/add-new', [PersonnelController::class, 'store']);
    Route::patch('/admin/personnels/update-details/{personnel}', [PersonnelController::class, 'update']);
    Route::delete('/admin/personnels/delete-personnel/{personnel}', [PersonnelController::class, 'destroy']);

    // Transactions
    Route::get('/admin/transactions', [TransactionController::class, 'index']);

    // Users
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/edit-details/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update']);
    Route::patch('/admin/users/update-user-logon/{user}', [UserController::class, 'updateUserLogon']);
    Route::post('/admin/users/toggle-active/{user}', [UserController::class, 'toggleActive']);
    Route::patch('/users/update-role/{user}', [UserController::class, 'updateRole'])->middleware('role:Administrator');
    Route::patch('/users/update-password/{user}', [UserController::class, 'updatePassword'])->middleware('role:Administrator');
    Route::delete('/users/delete/{user}', [UserController::class, 'destroy']);

    Route::get('/admin/items', [ItemController::class, 'index'])->name('item.index');
    // Route::get('/items/add-item', [ItemController::class, 'create'])->name('item.create');
    // Route::get('/items/add-to-existing', [ItemController::class, 'createExisting']);
    // Route::put('/items/add-to-existing/{item}', [ItemController::class, 'storeToExisting']);
    // Route::post('/items', [ItemController::class, 'store'])->name('item.store');
    // Route::get('/items/edit/{item}', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/admin/items/{item}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/admin/items/delete-item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::delete('/items/delete-items', [ItemController::class, 'bulkDelete']);

    // Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');

    //Categories
    Route::get('/admin/categories', [CategoryController::class, 'index']);
    Route::post('/admin/categories/add-new-category', [CategoryController::class, 'store']);
    Route::patch('/admin/categories/update-category/{category}', [CategoryController::class, 'update']);
    Route::delete('/admin/categories/delete-category/{category}', [CategoryController::class, 'destroy']);

    //Units
    Route::get('/admin/units', [UnitController::class, 'index']);
    Route::post('/admin/units/add-new-unit', [UnitController::class, 'store']);
    Route::patch('/admin/units/update-details/{unit}', [UnitController::class, 'update']);
    Route::delete('/admin/units/delete-unit/{unit}', [UnitController::class, 'destroy']);


    Route::get('/admin/purchases', [PurchaseController::class, 'index']);
    Route::post('/admin/purchases/store-item', [PurchaseController::class, 'storeItem']);
    Route::patch('/admin/purchases/add-to-existing/{item}', [PurchaseController::class, 'addToExistingItem']);
    Route::post('/admin/purchases/store-property', [PurchaseController::class, 'storeProperty']);

    // Flash Message Handler
    Route::post('/reset-flash-message', [HandleFlashMessageController::class, 'forget'])->name('flashMessageHandler');


    // API Endpoints
    Route::get('/api/units', [ItemApiController::class, 'getUnits']);

    Route::get('/api/categories', [ItemApiController::class, 'getCategories']);

    Route::get('/api/items', [ItemApiController::class, 'getItems']);
    Route::get('/api/items/{item}', [ItemApiController::class, 'getItem']);

    Route::get('/api/offices/{office}', [OfficeApiController::class, 'getOffice']);

    Route::get('/api/properties/{property}', [PropertyApiController::class, 'getProperty']);
    
    Route::get('/api/users', [UserApiController::class, 'getUsers']);
    Route::get('/api/users/no-offices', [UserApiController::class, 'loadUsersWithNoOffice']); //retrieves users with no office

    Route::get('/api/personnels/{personnel}', [PersonnelApiController::class, 'getPersonnel']);
});

require __DIR__.'/auth.php';
