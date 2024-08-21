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

    /**
     * Get a donation
     * @param int $id
     * @return Donation
     * @throws Exception
     */
    public function getDonation(int $id): Donation
    {
        try {
            $donation = Donation::find($id);
            if (!$donation) {
                throw new Exception('Donation not found', 404);
            }
            return $donation;
        } catch (Exception $e) {
            throw new Exception('An error occurred while fetching donation', 500);
        }
    }
}
