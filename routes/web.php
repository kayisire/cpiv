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
Route::get('/accounts/types/new', [UserController::class, 'newType'])->middleware('auth');
Route::post('/accounts/types/new', [UserController::class, 'addType'])->middleware('auth')->name('types');
Route::get('/accounts/types/{id}/activate', [UserController::class, 'activateType'])->middleware('auth');
Route::get('/accounts/types/{id}/disable', [UserController::class, 'disableType'])->middleware('auth');
Route::get('/accounts/types', [UserController::class, 'types'])->middleware('auth');
Route::get('/accounts/{id}/activate', [UserController::class, 'activateAccount'])->middleware('auth');
Route::get('/accounts/{id}/disable', [UserController::class, 'disableAccount'])->middleware('auth');
Route::get('/accounts/{id}/assign', [UserController::class, 'assignAccount'])->middleware('auth');
Route::post('/accounts/assign', [UserController::class, 'makeAssignAccount'])->middleware('auth')->name('assignType');
Route::get('/accounts/{userId}/assign/{typeId}/remove', [UserController::class, 'removeAssignAccount'])->middleware('auth');

Route::get('/projects', [ProjectController::class, 'index'])->middleware('auth');
Route::get('/projects/new', [ProjectController::class, 'new'])->middleware('auth');
Route::post('/projects/new', [ProjectController::class, 'store'])->middleware('auth')->name('projects');
Route::get('/projects/pending', [ProjectController::class, 'pending'])->middleware('auth');
Route::get('/projects/all', [ProjectController::class, 'all'])->middleware('auth');
Route::get('/projects/{id}/approve', [ProjectController::class, 'approve'])->middleware('auth');
Route::get('/projects/{id}/suspend', [ProjectController::class, 'suspend'])->middleware('auth');
Route::get('/projects/{id}/delete', [ProjectController::class, 'delete'])->middleware('auth');
Route::get('/projects/{id}/view', [ProjectController::class, 'view'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'store'])->middleware('auth')->name('profile');
