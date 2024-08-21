<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'target_amount',
        'collected_amount',
        'completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
