<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Manager\StockController as ManagerStockController;
use App\Http\Controllers\Manager\ReportController as ManagerReportController;
use App\Http\Controllers\Manager\StockOpnameController as ManagerStockOpnameController;
use App\Http\Controllers\Staff\StockConfirmController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Hanya Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', AdminUserController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    });

// Admin & Manajer
Route::middleware(['auth', 'role:admin,manajer_gudang'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('products/export', [AdminProductController::class, 'export'])->name('products.export');
        Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
        Route::resource('products', AdminProductController::class);
        Route::post('products/{product}/attributes', [ProductAttributeController::class, 'store'])->name('products.attributes.store');
        Route::delete('products/{product}/attributes/{attribute}', [ProductAttributeController::class, 'destroy'])->name('products.attributes.destroy');
        Route::resource('suppliers', AdminSupplierController::class);
    });

// Admin, Manajer & Staff - stok dan opname
Route::middleware(['auth', 'role:admin,manajer_gudang,staff_gudang'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::resource('stock', ManagerStockController::class);
        Route::resource('opname', ManagerStockOpnameController::class);
    });

// Admin & Manajer - laporan
Route::middleware(['auth', 'role:admin,manajer_gudang'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ManagerReportController::class, 'index'])->name('index');
            Route::get('/stock', [ManagerReportController::class, 'stock'])->name('stock');
            Route::get('/transactions', [ManagerReportController::class, 'transactions'])->name('transactions');
        });
    });

// Admin only - laporan aktivitas
Route::middleware(['auth', 'role:admin'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('reports/activity', [ManagerReportController::class, 'activity'])->name('reports.activity');
    });

// Staff - konfirmasi barang
Route::middleware(['auth', 'role:staff_gudang,admin,manajer_gudang'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('confirm', [StockConfirmController::class, 'index'])->name('confirm.index');
        Route::post('confirm/{id}', [StockConfirmController::class, 'confirm'])->name('confirm.store');
    });

require __DIR__.'/auth.php';