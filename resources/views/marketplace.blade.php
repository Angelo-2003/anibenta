@extends('layout')

@section('content')
    <!-- Success Message for OTP -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 p-4 mb-6 shadow-sm font-bold text-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Geographic Filter -->
    <div class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Filter by Barangay Hub</label>
                <select name="barangay_id" class="w-full border-gray-300 rounded-md shadow-sm p-2 bg-gray-50 focus:border-green-500 focus:ring-green-500">
                    <option value="all">All Barangays</option>
                    @foreach($barangays as $barangay)
                        <option value="{{ $barangay->id }}" {{ request('barangay_id') == $barangay->id ? 'selected' : '' }}>
                            {{ $barangay->barangay_name }}, {{ $barangay->city_municipality }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full md:w-auto bg-green-600 text-white font-bold px-6 py-2 rounded-md hover:bg-green-700 transition">
                Search
            </button>
        </form>
    </div>

    <!-- Crop Listings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($listings as $listing)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="p-5 flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h2 class="text-xl font-extrabold text-gray-900">{{ $listing->crop_name }}</h2>
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">{{ $listing->category }}</span>
                    </div>
                    
                    <p class="text-2xl font-bold text-green-600 mb-4">
                        ₱{{ number_format($listing->price_per_unit, 2) }} <span class="text-sm text-gray-500 font-normal">/ {{ $listing->unit_type }}</span>
                    </p>

                    <div class="space-y-1 mb-4">
                        <p class="text-sm text-gray-700 flex justify-between border-b pb-1">
                            <span>📦 Available Stock:</span> 
                            <span class="font-bold">{{ number_format($listing->available_stock) }}</span>
                        </p>
                        <p class="text-sm text-red-600 flex justify-between border-b pb-1">
                            <span>⚠️ Minimum Order (MOQ):</span> 
                            <span class="font-bold">{{ number_format($listing->moq_units) }}</span>
                        </p>
                    </div>

                    <div class="text-xs text-gray-500 space-y-1 mt-4">
                        <p>🧑‍🌾 Farmer: <span class="font-bold">{{ $listing->farmerSubaccount->farmer_name }}</span></p>
                        <p>📍 Hub: <span class="font-bold">{{ $listing->barangay->barangay_name }} ({{ $listing->pickup_hub }})</span></p>
                    </div>
                </div>
                
                <div class="p-4 bg-gray-50 border-t">
                    <a href="{{ route('checkout.show', $listing->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-bold transition">
                        Order Wholesale
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-8 text-center rounded-lg shadow-sm border border-gray-200 text-gray-500">
                <p class="text-lg font-bold mb-1">No Active Harvests</p>
                <p class="text-sm">Please check back later or select a different Barangay.</p>
            </div>
        @endforelse
    </div>
@endsection