<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('clients', App\Http\Controllers\ClientController::class);

Route::resource('legal-cases', App\Http\Controllers\LegalCaseController::class);

Route::resource('documents', App\Http\Controllers\DocumentController::class);

Route::resource('appointments', App\Http\Controllers\AppointmentController::class);
