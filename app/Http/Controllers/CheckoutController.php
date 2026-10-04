<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show(Listing $listing)
    {
        $listing->load(['farmerSubaccount', 'barangay']);
        return view('checkout', compact('listing'));
    }

    public function store(Request $request, Listing $listing)
    {
        // 1. Enforce Minimum Order Quantity (MOQ)
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:20',
            'quantity_ordered' => 'required|integer|min:' . $listing->moq_units . '|max:' . $listing->available_stock,
            'pickup_method' => 'required|string'
        ]);

        // 2. Calculate Escrow Financials
        $subtotal = $request->quantity_ordered * $listing->price_per_unit;
        $platform_fee = $subtotal * 0.05; // 5% AniBenta Revenue
        $farmer_payout = $subtotal * 0.95; // 95% Farmer Payout
        
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // 3. Database Transaction (Protects against errors during saving)
        DB::transaction(function () use ($request, $listing, $subtotal, $platform_fee, $farmer_payout, $otp) {
            Order::create([
                'listing_id' => $listing->id,
                'buyer_name' => $request->buyer_name,
                'buyer_phone' => $request->buyer_phone,
                'quantity_ordered' => $request->quantity_ordered,
                'total_amount' => $subtotal,
                'platform_fee' => $platform_fee,
                'farmer_net_payout' => $farmer_payout,
                'pickup_method' => $request->pickup_method,
                'pickup_otp' => $otp,
                'status' => 'CONFIRMED'
            ]);

            // Deduct purchased stock from the listing
            $listing->decrement('available_stock', $request->quantity_ordered);
        });

        return redirect()->route('home')->with('success', "Order confirmed! Your Pickup OTP is: " . $otp);
    }
}