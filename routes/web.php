<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\FactoryController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Distributor Routes
Route::middleware(['distributor'])->group(function () {
    Route::get('/distributor/dashboard', [DistributorController::class, 'dashboard'])->name('distributor.dashboard');
    // Add more distributor-specific routes here
});

// Supervisor Routes
Route::middleware(['supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
    // Add more supervisor-specific routes here
});

// Factory Routes
Route::middleware(['factory'])->group(function () {
    Route::get('/factory/dashboard', [FactoryController::class, 'dashboard'])->name('factory.dashboard');
    // Add more factory-specific routes here
});
