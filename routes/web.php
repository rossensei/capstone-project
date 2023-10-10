<?php

use App\Models\Item;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Facility;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\UserWithItemsController;

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
        'facilities' => Facility::count(),
        'items' => Item::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::get('/facilities/view/{facility}', [FacilityController::class, 'show'])->name('facilities.show');
    Route::get('/facilities/edit/{facility}', [FacilityController::class, 'edit'])->name('facilities.edit');
    Route::patch('/facilities/{facility}', [FacilityController::class, 'update'])->name('facilities.update');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    Route::delete('/facilities/remove-facility/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::post('/users/toggle-active/{user}', [UserController::class, 'toggleActive']);
    Route::patch('/users/update-role/{user}', [UserController::class, 'updateRole'])->middleware('role:admin');
    Route::patch('/users/update-password/{user}', [UserController::class, 'updatePassword'])->middleware('role:admin');
    Route::delete('/users/delete/{user}', [UserController::class, 'destroy']);

    Route::get('/inventory', [ItemController::class, 'index'])->name('inventory.index');

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');

    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');

    Route::get('/item-usages', [UserWithItemsController::class, 'index']);
});

require __DIR__.'/auth.php';
