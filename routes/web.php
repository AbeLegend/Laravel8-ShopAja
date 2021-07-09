<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
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
Route::get('/', [ItemController::class, 'showAll'])->middleware(['auth', 'verified']);
Route::get('/user/{user}/my-item', [UserController::class, 'show'])->middleware(['auth']);
Route::post('/items', [ItemController::class, 'store'])->middleware('auth');
Route::get('/items/create', [ItemController::class, 'create'])->middleware('auth');
Route::get('/items/{item}', [ItemController::class, 'show'])->middleware('auth');
Route::put('/items/{item}', [ItemController::class, 'update'])->middleware('auth');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->middleware('auth');
Route::post('/items/{item}/checkout', [ItemController::class, 'checkout'])->middleware('auth');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->middleware('auth');
// User Authentication
Route::view('/profile/edit', 'profile.edit')->middleware(['auth', 'verified']);
Route::view('/profile/password', 'profile.password')->middleware(['auth']);
