<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerSubaccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'farmer_name',
        'contact_number'
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}