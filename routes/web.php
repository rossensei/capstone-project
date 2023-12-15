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
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ItemApiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\VenueApiController;
use App\Http\Controllers\OfficeApiController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PropertyApiController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AssetManagerController;
use App\Http\Controllers\FindPropertyController;
use App\Http\Controllers\PersonnelApiController;
use App\Http\Controllers\DepartmentApiController;
use App\Http\Controllers\VenuePropertyController;
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

    Route::group(['middleware' => ['role:Asset Manager']], function () {
        Route::get('/asset-manager-access/my-venue', [AssetManagerController::class, 'index']);
    });

    Route::group(['middleware' => ['permission:manage-inventory']], function () {

        // Venues
        Route::get('/venues', [VenueController::class, 'index'])->name('venue.index');
        Route::post('/venues/new-venue', [VenueController::class, 'store'])->name('venue.store');
        Route::patch('/venues/update-details/{venue}', [VenueController::class, 'update'])->name('venue.update');
        Route::delete('/venues/remove-venue/{venue}', [VenueController::class, 'destroy'])->name('venue.destroy');

        // Venue Properties
        Route::get('/venues/show-properties/{venue}', [VenuePropertyController::class, 'index']);
        Route::post('/venues/show-properties/{venue}/move-property', [VenuePropertyController::class, 'moveProperty']);
        Route::post('/venues/show-properties/{venue}/update-status', [VenuePropertyController::class, 'updateStatus']);

        // All Properties
        Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');
        Route::post('/properties/add-new', [PropertyController::class, 'store'])->name('property.store');
        Route::patch('/properties/update-details/{property}', [PropertyController::class, 'update'])->name('property.update');
        Route::delete('/properties/delete/{property}', [PropertyController::class, 'destroy'])->name('property.destroy');

        // Offices
        Route::get('/offices', [OfficeController::class, 'index'])->name('office.index');
        // Route::get('/offices/create', [OfficeController::class, 'create'])->name('office.create');
        Route::get('/offices/view-transactions/{office}', [OfficeController::class, 'show']);
        Route::get('/offices/transactions/{office}/{transaction}', [OfficeController::class, 'transactionDetails']);
        Route::patch('/offices/update-details/{office}', [OfficeController::class, 'update'])->name('office.update');
        Route::post('/offices/new-office', [OfficeController::class, 'store'])->name('office.store');
        Route::delete('/offices/remove-office/{office}', [OfficeController::class, 'destroy'])->name('office.destroy');

        // Sales
        Route::get('/sales', [SaleController::class, 'index'])->name('sale.index');
        Route::post('/sales/add-new', [SaleController::class, 'store'])->name('sale.store');
        Route::patch('/sales/update-details/{sale}', [SaleController::class, 'update'])->name('sale.update');
        Route::delete('/sales/delete-sale/{sale}', [SaleController::class, 'destroy'])->name('sale.destroy');
    
        // Personnels
        Route::get('/personnels', [PersonnelController::class, 'index']);
        Route::post('/personnels/add-new', [PersonnelController::class, 'store']);
        Route::patch('/personnels/update-details/{personnel}', [PersonnelController::class, 'update']);
        Route::delete('/personnels/delete-personnel/{personnel}', [PersonnelController::class, 'destroy']);

        // Transactions
        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/create', [TransactionController::class, 'create']);
        Route::post('/transactions/new-transaction', [TransactionController::class, 'store']);
        Route::get('/transactions/edit-details/{transaction}', [TransactionController::class, 'edit']);
        Route::get('/transactions/view-details/{transaction}', [TransactionController::class, 'show']);
        Route::patch('/transactions/update-details/{transaction}', [TransactionController::class, 'update']);
        Route::delete('/transactions/delete-transaction/{transaction}', [TransactionController::class, 'destroy']);
        Route::get('/transactions/report', [TransactionController::class, 'generatePdf']);


        // Items
        Route::get('/items', [ItemController::class, 'index'])->name('item.index');
        Route::post('/items/add-item', [ItemController::class, 'store'])->name('item.store');
        Route::put('/items/{item}', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/items/delete-item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
        Route::delete('/items/delete-items', [ItemController::class, 'bulkDelete']);

        // Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');

        //Categories
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories/add-new-category', [CategoryController::class, 'store']);
        Route::patch('/categories/update-category/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/delete-category/{category}', [CategoryController::class, 'destroy']);

        //Units
        Route::get('/units', [UnitController::class, 'index']);
        Route::post('/units/add-new-unit', [UnitController::class, 'store']);
        Route::patch('/units/update-details/{unit}', [UnitController::class, 'update']);
        Route::delete('/units/delete-unit/{unit}', [UnitController::class, 'destroy']);

        // Purchases
        Route::get('/purchases', [PurchaseController::class, 'index']);
        Route::post('/purchases/store-item', [PurchaseController::class, 'storeItem']);
        Route::post('/purchases/replenish-item', [PurchaseController::class, 'replenish']);
        Route::post('/purchases/store-property', [PurchaseController::class, 'storeProperty']);
    });
    // Route::get('/office-head/my-office', [])

    // Find Property
    Route::get('/find-property', [FindPropertyController::class, 'index']);
    Route::get('/find-property/search/{searchTerm}', [FindPropertyController::class, 'search']);

    // Users
    Route::group(['middleware' => ['role:Administrator']], function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/admin/users/edit-details/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/admin/users/{user}', [UserController::class, 'update']);
        Route::patch('/admin/users/update-user-logon/{user}', [UserController::class, 'updateUserLogon']);
        Route::post('/admin/users/toggle-active/{user}', [UserController::class, 'toggleActive']);
        Route::patch('/users/update-role/{user}', [UserController::class, 'updateRole'])->middleware('role:Administrator');
        Route::patch('/users/update-password/{user}', [UserController::class, 'updatePassword'])->middleware('role:Administrator');
        Route::delete('/users/delete/{user}', [UserController::class, 'destroy']);
    });


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

    Route::get('/api/venues', [VenueApiController::class, 'getVenues']);
    Route::get('/api/venues/{venue}', [VenueApiController::class, 'getVenue']);
});

require __DIR__.'/auth.php';
