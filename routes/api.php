<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return response()->json(['message' => 'Crowdfunding API', 'status' => 'Connected']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/donations', [DonationController::class, 'createDonation']);
    Route::get('/donations/{id}', [DonationController::class, 'getDonation']);
    Route::get('/donations', [DonationController::class, 'getPaginatedDonations']);
});

Route::post('/donations/{id}/donate', [DonationController::class, 'donate']);
