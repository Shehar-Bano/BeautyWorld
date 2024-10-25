<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;

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

require __DIR__.'/auth.php';
Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::post('/permission/store', [PermissionController::class, 'post'])->name('permissions.store');


///////////////////services/////////////////
//------------------category--------------//
Route::resource('service_categories', ServiceCategoryController::class)->names([
    'store' => 'service_categories.store',
    'destroy'=>'service_categories.destroy'
]);
//----------------Service-------------//
Route::resource('services',ServiceController::class);
