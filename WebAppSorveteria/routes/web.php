<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SorveteriaWebController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetEmail'])->name('password.email');

Route::middleware(['firebase'])->group(function () {
    //Route::get('/home', [AuthController::class, 'home']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/home', [SorveteriaWebController::class, 'index'])->name('sorveteria.index');
    Route::get('/create', [SorveteriaWebController::class, 'create'])->name('sorveteria.create');
    Route::post('/store', [SorveteriaWebController::class, 'store'])->name('sorveteria.store');
    Route::get('/edit/{id}', [SorveteriaWebController::class, 'edit'])->name('sorveteria.edit');
    Route::post('/update/{id}', [SorveteriaWebController::class, 'update'])->name('sorveteria.update');
    Route::get('/delete/{id}', [SorveteriaWebController::class, 'destroy'])->name('sorveteria.destroy');

});