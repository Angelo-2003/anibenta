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

    <!-- Active Orders Section -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-6xl mx-auto mt-8 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Pending Fulfillment Orders</h2>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm">
                    <th class="p-3 border-b">Order ID</th>
                    <th class="p-3 border-b">Buyer Info</th>
                    <th class="p-3 border-b">Crop & Farmer</th>
                    <th class="p-3 border-b">Total & Fees</th>
                    <th class="p-3 border-b text-center">OTP</th>
                    <th class="p-3 border-b text-center">Status/Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50 text-sm">
                        <td class="p-3 font-bold text-gray-600">#{{ $order->id }}</td>
                        <td class="p-3">
                            <p class="font-bold">{{ $order->buyer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->buyer_phone }}</p>
                            <p class="text-xs text-blue-600 font-semibold mt-1">{{ $order->pickup_method }}</p>
                        </td>
                        <td class="p-3">
                            <p class="font-bold">{{ $order->listing->crop_name }}</p>
                            <p class="text-xs text-gray-600">{{ $order->quantity_ordered }} {{ $order->listing->unit_type }}s</p>
                            <p class="text-xs text-gray-500 mt-1">🧑‍🌾 {{ $order->listing->farmerSubaccount->farmer_name }}</p>
                        </td>
                        <td class="p-3">
                            <p class="font-bold text-green-700">₱{{ number_format($order->total_amount, 2) }}</p>
                            <p class="text-xs text-gray-500">Platform Fee: ₱{{ number_format($order->platform_fee, 2) }}</p>
                            <p class="text-xs text-gray-500">Farmer Net: ₱{{ number_format($order->farmer_net_payout, 2) }}</p>
                        </td>
                        <td class="p-3 text-center">
                            <span class="bg-yellow-100 text-yellow-800 font-mono font-bold px-2 py-1 rounded tracking-widest">
                                {{ $order->pickup_otp }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            @if($order->status === 'CONFIRMED')
                                <form action="{{ route('dashboard.completeOrder', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-600 text-white text-xs font-bold px-3 py-2 rounded hover:bg-green-700 transition">
                                        Release Crop
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 font-bold text-xs bg-gray-200 px-3 py-1 rounded uppercase">{{ $order->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500 font-bold">No orders placed yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection