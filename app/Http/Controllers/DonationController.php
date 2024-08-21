<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDonationRequest;
use App\Services\DonationService;
use Exception;
use Illuminate\Http\JsonResponse;

class DonationController extends Controller
{
    protected DonationService $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    /**
     * @param CreateDonationRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createDonation(CreateDonationRequest $request): JsonResponse
    {
        try {
            $donation = $this->donationService->createDonation($request->validated());

            return response()->json([
                'message' => 'Donation created successfully',
                'donation' => $donation,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
