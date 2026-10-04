<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_municipality',
        'barangay_name',
        'province'
    ];

    public function farmerSubaccounts()
    {
        return $this->hasMany(FarmerSubaccount::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}