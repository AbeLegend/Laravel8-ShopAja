<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
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

// Item Route
Route::get('/', [ItemController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/user/my-item', [ItemController::class, 'myItem'])->middleware(['auth']);
Route::post('/items', [ItemController::class, 'store'])->middleware('auth');
Route::get('/items/create', [ItemController::class, 'create'])->middleware('auth');
Route::get('/items/{item}', [ItemController::class, 'show'])->middleware('auth');
Route::put('/items/{item}', [ItemController::class, 'update'])->middleware('auth');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->middleware('auth');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->middleware('auth');
// User Authentication
Route::view('/profile/edit', 'profile.edit')->middleware(['auth', 'verified']);
Route::view('/profile/password', 'profile.password')->middleware(['auth']);

// Cart Route
Route::get('/carts', [CartController::class, 'show'])->middleware('auth');
Route::post('/carts', [CartController::class, 'store'])->middleware('auth');
Route::post('/carts/buyOne', [CartController::class, 'buyOne'])->middleware('auth');
Route::delete('/carts/{cart}', [CartController::class, 'destroy'])->middleware('auth');
Route::post('/carts/purchase-amount', [CartController::class, 'purchaseAmount'])->middleware('auth');

// Transaction
Route::get('/checkout', [TransactionController::class, 'checkout'])->middleware('auth');
Route::get('/transactions', [TransactionController::class, 'show'])->middleware('auth');
Route::get('/transactions/history', [TransactionController::class, 'history'])->middleware('auth');
Route::post('/transactions/pay', [TransactionController::class, 'pay'])->middleware('auth');
Route::post('/checkout/now', [TransactionController::class, 'makeTrx'])->middleware('auth');
Route::post('/transactions/print-buyer', [TransactionController::class, 'printBuyer'])->middleware('auth');
Route::post('/transactions/print-seller', [TransactionController::class, 'printSeller'])->middleware('auth');
