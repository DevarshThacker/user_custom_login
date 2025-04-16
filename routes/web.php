<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\UsersController;


Route::get('login', [AuthController::class, 'index'])->name('login');

Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('registration', [AuthController::class, 'registration'])->name('register');

Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('edit/{id}', [AuthController::class, 'edit'])->name('edit');

Route::post('update/{id}', [AuthController::class, 'update'])->name('update');

Route::delete('destroy/{id}', [AuthController::class, 'destroy'])->name('destroy');


Route::get('/', function () {
    return view('welcome');
});
