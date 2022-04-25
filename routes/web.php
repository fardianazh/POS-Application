<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/api/category', [App\Http\Controllers\CategoryController::class, 'api']);
Route::get('/api/product', [App\Http\Controllers\ProductController::class, 'api']);
Route::get('/api/transaction', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/api/supplier', [App\Http\Controllers\SupplierController::class, 'api']);
Route::get('/api/user', [App\Http\Controllers\UserController::class, 'api']);

Route::resource('/category', App\Http\Controllers\CategoryController::class);
Route::resource('/product', App\Http\Controllers\ProductController::class);
Route::resource('/transaction', App\Http\Controllers\TransactionController::class);
Route::resource('/supplier', App\Http\Controllers\SupplierController::class);
Route::resource('/user', App\Http\Controllers\UserController::class);

// Route::get('/spatie/user', [App\Http\Controllers\UserController::class, 'spatie']);