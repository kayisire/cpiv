<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\UserByTypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [AdminController::class, 'index'])->middleware('auth');
Route::get('/admin/types', [UserTypeController::class, 'index'])->middleware('auth');
Route::post('/admin/types/create', [UserTypeController::class, 'store'])->middleware('auth')->name('createTypes');