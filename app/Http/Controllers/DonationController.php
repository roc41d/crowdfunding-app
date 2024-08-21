<?php

namespace App\Http\Controllers;

use App\Exceptions\DonationCompletedException;
use App\Exceptions\DonationNotFoundException;
use App\Http\Requests\CreateDonationRequest;
use App\Http\Requests\DonateRequest;
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

    public function getDonation($id): JsonResponse
    {
        try {
            $donation = $this->donationService->getDonation($id);

            return response()->json([
                'message' => 'Donation fetched successfully',
                'donation' => $donation,
            ], 200);
        } catch (DonationNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    public function donate(DonateRequest $request, int $id)
    {
        try {
            $donation = $this->donationService->processDonation($request->validated(), $id);

            return response()->json([
                'message' => 'Donation processed successfully',
                'donation' => $donation,
            ], 200);
        } catch (DonationNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        } catch (DonationCompletedException $e) {
            return response()->json([
                'info' => $e->getMessage(),
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
