<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetCopyController;
use App\Http\Controllers\BudgetGuideController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// All routes require authentication.
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Income
    Route::get('/income/create', [IncomeController::class, 'create'])->name('income.create');
    Route::post('/income', [IncomeController::class, 'store'])->name('income.store');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::post('/transactions/{transaction}/update', [TransactionController::class, 'update'])->name('transactions.update');
    Route::post('/transactions/{transaction}/delete', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Budget
    Route::get('/budget', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('/budget/guide', BudgetGuideController::class)->name('budget.guide');
    Route::get('/budget/{category}/edit', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::post('/budget/{category}/update', [BudgetController::class, 'update'])->name('budget.update');
    Route::post('/budget/copy', [BudgetCopyController::class, 'store'])->name('budget.copy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Goals
    Route::get('/goals', [GoalController::class, 'index'])->name('goals.index');
    Route::get('/goals/create', [GoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
    Route::get('/goals/{goal}/edit', [GoalController::class, 'edit'])->name('goals.edit');
    Route::post('/goals/{goal}/update', [GoalController::class, 'update'])->name('goals.update');
    Route::post('/goals/{goal}/delete', [GoalController::class, 'destroy'])->name('goals.destroy');

    // Stats
    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

    // Settings & Export/Import
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/export/csv', [ExportController::class, 'csv'])->name('export.csv');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

});

require __DIR__.'/auth.php';
