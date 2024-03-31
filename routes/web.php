<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'worker'])->group(function () {

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

    Route::controller(InvoiceController::class)->prefix('invoices')->group(function () {
        Route::get('/', 'index')->name('invoices.index');
        Route::get('/show/{invoice:number}', 'show')->name('invoices.show');
        Route::get('/customer/{customer}', 'customer')->name('invoices.customer');
        Route::get('/create/{customer}/{project}', 'create')->name('invoices.create');
        Route::post('/save', 'save')->name('invoices.save');
        Route::post('/update/{invoice}', 'update')->name('invoices.update');
    });

    Route::controller(PaymentController::class)->prefix('payments')->group(function () {
        Route::get('/', 'index')->name('payments.index');
        Route::post('/save/{invoice}', 'save')->name('payments.save');
    });

    Route::controller(SubscriptionController::class)->prefix('invoice-items')->group(function () {
        Route::post('update-subs/{subscription}', 'updateSubs')->name('invoice-item.update-subs');
        Route::post('add-subs/{invoice}', 'addSubs')->name('invoice-item.add-subs');
        Route::post('continue-subs/{subscription}', 'continueSubs')->name('invoice-item.continue-subs');

        Route::post('update-service/{service}', 'updateService')->name('invoice-item.update-service');
        Route::post('add-service/{invoice}', 'addService')->name('invoice-item.add-service');
    });

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users/save/{user?}', [UserController::class, 'save'])->name('users.save');

        Route::get('logs', [\App\Http\Controllers\LogController::class, 'index'])->name('logs.index');
    });

});

Auth::routes(['reset' => false, 'verify' => false, 'register' => false]);
