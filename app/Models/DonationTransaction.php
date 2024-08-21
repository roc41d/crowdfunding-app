<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationTransaction extends Model
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'donation_id',
        'amount',
        'donor_name',
        'donor_email',
    ];

    protected $casts = [
        'donation_id' => 'integer',
        'amount' => 'decimal:2',
        'donor_name' => 'string',
        'donor_email' => 'string',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
