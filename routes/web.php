<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UsageRecordController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Spare Parts Management
    Route::resource('spare-parts', SparePartController::class);
    
    // Suppliers Management (Manager only)
    Route::resource('suppliers', SupplierController::class)
        ->middleware(App\Http\Middleware\EnsureUserIsManager::class);
    
    // Manager-only spare parts actions
    Route::middleware(App\Http\Middleware\EnsureUserIsManager::class)->group(function () {
        Route::get('/spare-parts/create', [SparePartController::class, 'create'])->name('spare-parts.create');
        Route::post('/spare-parts', [SparePartController::class, 'store'])->name('spare-parts.store');
        Route::get('/spare-parts/{spare_part}/edit', [SparePartController::class, 'edit'])->name('spare-parts.edit');
        Route::put('/spare-parts/{spare_part}', [SparePartController::class, 'update'])->name('spare-parts.update');
        Route::delete('/spare-parts/{spare_part}', [SparePartController::class, 'destroy'])->name('spare-parts.destroy');
    });
    
    // Read-only spare parts routes for all users
    Route::get('/spare-parts', [SparePartController::class, 'index'])->name('spare-parts.index');
    Route::get('/spare-parts/{spare_part}', [SparePartController::class, 'show'])->name('spare-parts.show');
    
    // Usage Records
    Route::resource('usage-records', UsageRecordController::class)->except(['edit', 'destroy']);
    
    // Usage Record Approval (Manager only)
    Route::patch('/usage-records/{usage_record}/approve', [UsageRecordController::class, 'update'])
        ->name('usage-records.approve')
        ->middleware(App\Http\Middleware\EnsureUserIsManager::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';