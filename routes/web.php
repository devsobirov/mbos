<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::controller(ProjectController::class)->prefix('projects')->group(function () {
        Route::get('/', 'index')->name('projects.index');
        Route::post('/save', 'save')->name('projects.save');
        Route::delete('/delete/{project}', 'delete')->name('projects.delete');
    });

    Route::controller(PlanController::class)->prefix('plans')->group(function () {
        Route::get('/{project}', 'show')->name('projects.plans');
        Route::post('/save-plan', 'save')->name('projects.save-plan');
        Route::delete('/delete-plan/{planId}', 'delete')->name('projects.delete-plan');
    });

    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('/', 'index')->name('customers.index');
        Route::post('/save', 'save')->name('customers.save');
    });

    Route::get('logs', [\App\Http\Controllers\LogController::class, 'index'])->name('logs.index');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

});


\Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
