<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});


use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserDashboardController;

// User dashboard (default)
Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])
	->middleware(['auth', 'verified'])
	->name('user.dashboard');

// Admin routes
// Use Spatie `role:admin` middleware for route protection
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
	Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
	Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
	Route::get('/users/{user}/dashboard', [AdminController::class, 'viewUserDashboard'])->name('admin.users.dashboard');

	// Category CRUD
	Route::resource('categories', CategoryController::class, [
		'as' => 'admin'
	]);
});


Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
