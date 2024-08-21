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

    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
