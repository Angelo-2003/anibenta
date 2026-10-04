<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\FarmerSubaccount;
use App\Models\Listing;

class DashboardController extends Controller
{
    public function index()
    {
        $farmers = FarmerSubaccount::with('barangay')->get();
        return view('dashboard', compact('farmers'));
    }

    public function storeListing(Request $request)
    {
        $request->validate([
            'farmer_subaccount_id' => 'required|exists:farmer_subaccounts,id',
            'crop_name' => 'required|string|max:255',
            'category' => 'required|string',
            'price_per_unit' => 'required|numeric|min:1',
            'unit_type' => 'required|string',
            'moq_units' => 'required|integer|min:1',
            'available_stock' => 'required|integer|min:1',
            'harvest_date' => 'required|date',
            'pickup_hub' => 'required|string',
        ]);

        // Automatically assign the correct Barangay Hub based on the chosen farmer
        $farmer = FarmerSubaccount::findOrFail($request->farmer_subaccount_id);

        Listing::create([
            'farmer_subaccount_id' => $farmer->id,
            'barangay_id' => $farmer->barangay_id,
            'crop_name' => $request->crop_name,
            'category' => $request->category,
            'price_per_unit' => $request->price_per_unit,
            'unit_type' => $request->unit_type,
            'moq_units' => $request->moq_units,
            'available_stock' => $request->available_stock,
            'harvest_date' => $request->harvest_date,
            'pickup_hub' => $request->pickup_hub,
            'is_active' => true,
        ]);

        return redirect()->route('dashboard.index')->with('success', 'New wholesale listing posted successfully!');
    }
}