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
Route::middleware(['auth:distributor'])->group(function () {
    Route::get('/distributor/dashboard', [DistributorController::class, 'dashboard'])->name('distributor.dashboard');
    Route::get('/distributor/create-request', [DistributorController::class, 'createRequest'])->name('distributor.create-request');
    Route::post('/distributor/store-request', [DistributorController::class, 'storeRequest'])->name('distributor.store-request');
    Route::delete('/distributor/delete-request/{id}', [DistributorController::class, 'deleteRequest'])->name('distributor.delete-request');
});

// Supervisor Routes
Route::middleware(['auth:supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
    Route::post('/supervisor/update-status', [SupervisorController::class, 'updateStatus'])->name('supervisor.update-status');
});

// Factory Routes
Route::middleware(['factory'])->group(function () {
    Route::get('/factory/dashboard', [FactoryController::class, 'dashboard'])->name('factory.dashboard');
    // Add more factory-specific routes here
});
