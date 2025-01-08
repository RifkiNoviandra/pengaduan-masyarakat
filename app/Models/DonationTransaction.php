<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationTransaction extends Model
{
    protected $fillable = [
        'donation_id',
        'user_id',
        'amount',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
