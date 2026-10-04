@extends('layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Barangay Proxy Dashboard</h1>
        <a href="{{ route('home') }}" class="text-green-600 hover:underline font-bold">View Marketplace &rarr;</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 p-4 mb-6 font-bold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Post New Harvest Listing</h2>
        <form action="{{ route('dashboard.storeListing') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Select Farmer</label>
                <select name="farmer_subaccount_id" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" required>
                    @foreach($farmers as $farmer)
                        <option value="{{ $farmer->id }}">{{ $farmer->farmer_name }} ({{ $farmer->barangay->barangay_name }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Crop Name</label>
                <input type="text" name="crop_name" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" required placeholder="e.g. Cabbage">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Vegetable">Vegetable</option>
                    <option value="Fruit">Fruit</option>
                    <option value="Grain">Grain</option>
                    <option value="Root Crop">Root Crop</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Price per unit (₱)</label>
                    <input type="number" step="0.01" name="price_per_unit" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Unit Type</label>
                    <input type="text" name="unit_type" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500" required placeholder="e.g. kg, sack">
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Available Stock (Total)</label>
                <input type="number" name="available_stock" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Minimum Order Qty (MOQ)</label>
                <input type="number" name="moq_units" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Harvest Date</label>
                <input type="date" name="harvest_date" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Exact Pickup Hub Location</label>
                <input type="text" name="pickup_hub" class="w-full border-gray-300 rounded p-2 bg-gray-50 focus:ring-blue-500" required placeholder="e.g. Brgy. Commonwealth Hall">
            </div>
            
            <div class="md:col-span-2 mt-4">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold text-lg py-3 rounded-md hover:bg-blue-700 shadow-md transition">
                    Post Wholesale Listing
                </button>
            </div>
        </form>
    </div>
@endsection