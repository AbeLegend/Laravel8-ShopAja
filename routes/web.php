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

// User Authentication
Route::view('/', 'home')->middleware(['auth', 'verified']);
Route::view('/profile/edit', 'profile.edit')->middleware(['auth', 'verified']);
Route::view('/profile/password', 'profile.password')->middleware(['auth']);
