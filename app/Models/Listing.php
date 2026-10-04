<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_subaccount_id',
        'barangay_id',
        'crop_name',
        'category',
        'price_per_unit',
        'unit_type',
        'moq_units',
        'available_stock',
        'harvest_date',
        'pickup_hub',
        'is_active'
    ];

    public function farmerSubaccount()
    {
        return $this->belongsTo(FarmerSubaccount::class);
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}