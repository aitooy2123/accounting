<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\AccountController;

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('income', IncomeController::class);
    Route::resource('expense', ExpenseController::class);
    Route::resource('invoice', InvoiceController::class);
    Route::resource('payment', PaymentController::class);

    // ระบบบัญชีคู่
    Route::resource('accounts', AccountController::class);
    Route::resource('journals', JournalEntryController::class);
});
