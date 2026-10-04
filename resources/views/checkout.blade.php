@extends('layout')

@section('content')
    <a href="{{ route('home') }}" class="text-green-700 hover:underline font-semibold mb-6 inline-block">&larr; Back to Marketplace</a>

    <div class="max-w-xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-6 border-b pb-4">Checkout: {{ $listing->crop_name }}</h1>
        
        <!-- Order Summary Data -->
        <div class="bg-gray-50 p-4 rounded-md mb-6 border border-gray-200">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Unit Price:</span>
                <span class="font-bold">₱{{ number_format($listing->price_per_unit, 2) }} / {{ $listing->unit_type }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Available Stock:</span>
                <span class="font-bold">{{ number_format($listing->available_stock) }} {{ $listing->unit_type }}s</span>
            </div>
            <div class="flex justify-between text-red-600">
                <span>Minimum Order (MOQ):</span>
                <span class="font-bold">{{ number_format($listing->moq_units) }} {{ $listing->unit_type }}s</span>
            </div>
            <hr class="my-3">
            <p class="text-sm text-gray-500">📍 Pickup Hub: {{ $listing->pickup_hub }}, {{ $listing->barangay->barangay_name }}</p>
        </div>

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc ml-4 text-sm font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Checkout Form -->
        <form method="POST" action="{{ route('checkout.store', $listing->id) }}" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-1">Full Name (Buyer)</label>
                <input type="text" name="buyer_name" class="w-full border-gray-300 bg-gray-50 p-2 rounded focus:ring-green-500 focus:border-green-500" required placeholder="e.g. Juan Dela Cruz">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-1">Contact Number</label>
                <input type="text" name="buyer_phone" class="w-full border-gray-300 bg-gray-50 p-2 rounded focus:ring-green-500 focus:border-green-500" required placeholder="09xxxxxxxxx">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-1">Quantity to Order ({{ $listing->unit_type }}s)</label>
                <input type="number" name="quantity_ordered" min="{{ $listing->moq_units }}" max="{{ $listing->available_stock }}" value="{{ $listing->moq_units }}" class="w-full border-gray-300 bg-gray-50 p-2 rounded focus:ring-green-500 focus:border-green-500 text-lg font-bold" required>
                <p class="text-xs text-gray-500 mt-1">Must be at least {{ $listing->moq_units }}. Cannot exceed {{ $listing->available_stock }}.</p>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-1">Fulfillment Method</label>
                <select name="pickup_method" class="w-full border-gray-300 bg-gray-50 p-2 rounded focus:ring-green-500 focus:border-green-500">
                    <option value="Self-Pickup">Self-Pickup at Barangay Hub</option>
                    <option value="Third-Party Logistics">Book Lalamove/Transportify (Buyer handles booking)</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold text-lg py-3 rounded-md hover:bg-green-700 shadow-md transition mt-4">
                Confirm Order & Generate OTP
            </button>
        </form>
    </div>
@endsection