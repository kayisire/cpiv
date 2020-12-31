<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserByTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;

Auth::routes();
Route::get('/', [AdminController::class, 'welcome']);
Route::get('/home', [AdminController::class, 'index'])->middleware('auth');

Route::get('/accounts', [UserController::class, 'index'])->middleware('auth');
Route::get('/projects', [ProjectController::class, 'index'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'store'])->middleware('auth')->name('profile');
