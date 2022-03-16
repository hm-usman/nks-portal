<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;


Auth::routes([
	'reset' => false,
	'register' => false
]);

Route::get('/', function(){
	return redirect()->route('login');
});

// admin
Route::get('/admin', [HomeController::class, 'index'])->name('admin')->middleware(['auth','can:isAdmin']);
Route::get('/admin/employees', [UsersController::class, 'index'] )->name('employees-list')->middleware(['auth','can:isAdmin']);
Route::get('/admin/create-employee', [UsersController::class,'create'] )->name('create-employee')->middleware(['auth','can:isAdmin']);
Route::post('/admin/create-employee', [UsersController::class,'store'] )->name('store-employee')->middleware(['auth','can:isAdmin']);
Route::get('/admin/employees/{id}', [UsersController::class,'profile'] )->name('view-employee')->middleware(['auth','can:isAdmin']);
Route::post('/admin/employees/{id}', [UsersController::class,'update'] )->name('update-employee')->middleware(['auth','can:isAdmin']);
Route::get('/admin/delete-employees/{id}', [UsersController::class,'destroy'])->name('delete-employee')->middleware(['auth','can:isAdmin']);

// Tasks
Route::get('/tasks', [TaskController::class,'index'])->name('tasks')->middleware('auth');
Route::post('/create-task', [TaskController::class,'store'])->name('task-save')->middleware('can:isAdmin');
Route::get('/update-status-task/{id}/{status}', [TaskController::class,'updateStatus'])->name('task-status-update')->middleware('auth');
Route::post('/update-task/{id}', [TaskController::class,'update'])->name('update-task')->middleware('can:isAdmin');
Route::get('/delete-task/{id}', [TaskController::class,'destroy'])->name('delete-task')->middleware('can:isAdmin');
Route::post('/upload-file/{id}', [TaskController::class,'uploadFile'])->name('upload-file')->middleware('can:isUser');

Route::get('/my-profile', [UsersController::class,'profile'])->name('my-profile')->middleware('auth');
Route::post('/my-profile/{id}', [UsersController::class,'update'])->name('update-profile')->middleware('can:isUser');