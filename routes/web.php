<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LegalCaseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes - redirect to login or dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Admin routes (for lawyers)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('clients', ClientController::class);
    Route::resource('legal-cases', LegalCaseController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('appointments', AppointmentController::class);
});

// Client portal routes
Route::middleware(['auth', 'verified'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/', [ClientPortalController::class, 'index'])->name('dashboard');
    Route::get('/cases', [ClientPortalController::class, 'cases'])->name('cases');
    Route::get('/cases/{legalCase}', [ClientPortalController::class, 'showCase'])->name('cases.show');
    Route::get('/documents', [ClientPortalController::class, 'documents'])->name('documents');
    Route::get('/appointments', [ClientPortalController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/create', [ClientPortalController::class, 'createAppointment'])->name('appointments.create');
    Route::post('/appointments', [ClientPortalController::class, 'storeAppointment'])->name('appointments.store');
});

// Profile routes (for all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth redirect based on role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('portal.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
