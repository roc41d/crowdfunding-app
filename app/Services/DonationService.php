<?php

namespace App\Services;

use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Exception;

class DonationService
{
    /**
     * Create a new donation
     * @param array $data
     * @return Donation
     * @throws Exception
     */
    public function createDonation(array $data): Donation
    {
        try {
            $donation = new Donation();
            $donation->user_id = Auth::id();
            $donation->title = $data['title'];
            $donation->description = $data['description'];
            $donation->target_amount = $data['target_amount'];
            $donation->save();

            return $donation;
        } catch (Exception $e) {
            throw new Exception('Fail to a donation: ' . $e->getMessage(), 500);
        }
    }
}
