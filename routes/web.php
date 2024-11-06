<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ServiceCartController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ExpenceCategoryController;
use App\Http\Controllers\ServiceCategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require_once __DIR__ . '/auth.php';

Route::prefix('permission')->name('permissions.')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::post('/store', [PermissionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PermissionController::class, 'show'])->name('edit');
    Route::post('/update/{id}', [PermissionController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('delete');
});
Route::prefix('role')->name('roles.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::post('/store', [RoleController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RoleController::class, 'show'])->name('edit');
    Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
});

Route::prefix('role-permission')->name('role.permission.')->group(function () {
    Route::get('/', [RolePermissionController::class, 'index'])->name('index');
    Route::get('/form', [RolePermissionController::class, 'create'])->name('form');
    Route::post('/', [RolePermissionController::class, 'store'])->name('store');
    Route::get('/show/{id}', [RolePermissionController::class, 'show'])->name('show');
    Route::put('/update/{id}', [RolePermissionController::class, 'update'])->name('update');
});
Route::prefix('user-role')->name('user.role.')->group(function () {
    Route::get('/', [RoleUserController::class, 'index'])->name('index');
    Route::get('/form', [RoleUserController::class, 'create'])->name('form');
    Route::post('/', [RoleUserController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RoleUserController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [RoleUserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoleUserController::class, 'destroy'])->name('delete');
});
Route::prefix('employee')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EmployeeController::class, 'destroy'])->name('delete');
});
Route::prefix('inventory')->name('inventories.')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('index');
    Route::get('/create',[InventoryController::class, 'create'])->name('create');
    Route::post('/store',[InventoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [InventoryController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [InventoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}',[InventoryController::class, 'destroy'])->name('delete');
});
Route::prefix('deal')->name('deals.')->group(function () {
    Route::get('/', [DealController::class, 'index'])->name('index');
    Route::get('/create',[DealController::class, 'create'])->name('create');
    Route::post('/store',[DealController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DealController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [DealController::class, 'update'])->name('update');
    Route::delete('/delete/{id}',[DealController::class, 'destroy'])->name('delete');
});
Route::prefix('expence_category')->name('expence_categories.')->group(function () {
    Route::get('/', [ExpenceCategoryController::class, 'index'])->name('index');
    Route::get('/create',[ExpenceCategoryController::class, 'create'])->name('create');
    Route::post('/store',[ExpenceCategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ExpenceCategoryController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ExpenceCategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}',[ExpenceCategoryController::class, 'destroy'])->name('delete');
});
Route::prefix('expence')->name('expences.')->group(function () {
    Route::get('/', [ExpenceController::class, 'index'])->name('index');
    Route::get('/create',[ExpenceController::class, 'create'])->name('create');
    Route::post('/store',[ExpenceController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ExpenceController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ExpenceController::class, 'update'])->name('update');
    Route::delete('/delete/{id}',[ExpenceController::class, 'destroy'])->name('delete');
});
Route::get('/expence-report', [ReportController::class, 'expence'])->name('expence.report');
Route::get('/sales-report', [ReportController::class, 'sale'])->name('sales.report');

///////////////////services/////////////////
//------------------category--------------//
Route::resource('service_categories', ServiceCategoryController::class)->names([
    'store' => 'service_categories.store',
    'destroy' => 'service_categories.destroy'
]);
//----------------Service-------------//
Route::resource('services', ServiceController::class);

/////////////////////orders////////////////////////////
//-----------------Cart------------------//

Route::prefix('carts')->name('cart.')->controller(ServiceCartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/get-seat-numbers',  'getSeatNumbers')->name('seat.numbers');
    Route::get('/get-cart-items/{seatNumber}', 'getCartItemsForSeat');
   
Route::post('/cart-update',  'update')->name('update');


Route::post('/cart/add', 'addToCart')->name('add');

Route::post('/confirm-order', 'confirmOrder')->name('order.confirm');
Route::post('/cart/empty', 'emptyCart')->name('empty');
});



