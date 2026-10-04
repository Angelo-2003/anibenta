<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Barangay;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $barangays = Barangay::all();
        
        // Eager load relationships to prevent database slowdowns
        $query = Listing::with(['farmerSubaccount', 'barangay'])->where('is_active', true);

        // Filter by Barangay if selected
        if ($request->has('barangay_id') && $request->barangay_id != 'all') {
            $query->where('barangay_id', $request->barangay_id);
        }

        $listings = $query->latest()->get();

        return view('marketplace', compact('listings', 'barangays', 'request'));
    }
}