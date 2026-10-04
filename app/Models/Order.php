<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'buyer_name',
        'buyer_phone',
        'quantity_ordered',
        'total_amount',
        'platform_fee',
        'farmer_net_payout',
        'pickup_method',
        'pickup_otp',
        'status'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}