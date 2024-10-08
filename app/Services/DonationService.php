<?php

namespace App\Services;

use App\Exceptions\DonationCompletedException;
use App\Exceptions\DonationNotFoundException;
use App\Models\Donation;
use App\Models\DonationTransaction;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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
            $donation = Donation::with('transactions')->find($id);
            if (!$donation) {
                throw new DonationNotFoundException('Donation not found', 404);
            }
            return $donation;
        } catch (DonationNotFoundException $e) {
            throw new DonationNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception('An error occurred while fetching donation', 500);
        }
    }

    /**
     * Process a donation
     * @param array $data
     * @param int $donation_id
     * @return DonationTransaction
     * @throws Exception
     */
    public function processDonation(array $data, int $donation_id): DonationTransaction
    {
        try {
            DB::beginTransaction();

            $donation = Donation::find($donation_id);
            if (!$donation) {
                throw new DonationNotFoundException('Donation not found', 404);
            }
            if ($donation->completed) {
                throw new DonationCompletedException('Donation already completed', 400);
            }

            $transaction = new DonationTransaction();
            $transaction->donation_id = $donation->id;
            $transaction->amount = $data["amount"];
            $transaction->donor_name = $data["donor_name"] ?? "Anonymous";
            $transaction->donor_email = $data["donor_email"] ?? null;
            $transaction->save();

            $donation->collected_amount += $data["amount"];
            if ($donation->collected_amount >= $donation->target_amount) {
                $donation->completed = true;
            }
            $donation->save();

            DB::commit();

            return $transaction;
        } catch (DonationNotFoundException $e) {
            DB::rollBack();
            throw new DonationNotFoundException($e->getMessage(), $e->getCode());
        } catch (DonationCompletedException $e) {
            DB::rollBack();
            throw new DonationCompletedException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('An error occurred while processing donation', 500);
        }
    }

    /**
     * Get paginated donations with configurable number per page.
     *
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function getPaginatedDonations(int $page = 1, int $perPage = 20): LengthAwarePaginator
    {
        try {
            $donations = Donation::paginate($perPage, ['*'], 'page', $page);

            if ($donations->isEmpty() && $page > 1) {
                throw new DonationNotFoundException('No donations found on this page.', 404);
            }

            return $donations;

        } catch (DonationNotFoundException $e) {
            throw new DonationNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception('An error occurred while fetching donations: ' . $e->getMessage());
        }
    }
}
