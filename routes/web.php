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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // การเงิน
    Route::resource('income', IncomeController::class);
    Route::resource('expense', ExpenseController::class);
    Route::resource('invoice', InvoiceController::class);
    Route::resource('payment', PaymentController::class);
    Route::post('/invoice/{invoice}/payment', [InvoiceController::class, 'storePayment'])->name('invoice.payment.store');
    // ลูกหนี้ / เจ้าหนี้
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);

    // ระบบบัญชี
    Route::resource('accounts', AccountController::class);
    Route::resource('journals', JournalEntryController::class);
    Route::resource('banks', BankController::class);

    // ผู้ใช้งาน / ตั้งค่า
    Route::resource('users', UserController::class);
    Route::resource('settings', SettingController::class);

    // รายงาน
    Route::prefix('reports')->name('reports.')->group(function () {

        Route::get('trial-balance', [ReportController::class, 'trialBalance'])->name('trial_balance');

        Route::get('profit-loss', [ReportController::class, 'profitLoss'])->name('profit_loss');

        Route::get('balance-sheet', [ReportController::class, 'balanceSheet'])->name('balance_sheet');

        Route::get('cashflow', [ReportController::class, 'cashflow'])->name('cashflow');
    });
});
