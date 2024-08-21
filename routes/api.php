<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationTransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/donations', [DonationController::class, 'createDonation']);
    Route::get('/donations/{id}', [DonationController::class, 'getDonation']);
    Route::post('/donations/{id}/donate', [DonationController::class, 'donate']);

    Route::post('/donation-transactions', [DonationTransactionController::class, 'donate']);
});
