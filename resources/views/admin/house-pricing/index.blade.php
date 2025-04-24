@extends('layouts.admin')

@section('title', 'Manage House Pricing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage House Pricing</h1>
        <a href="{{ route('admin.house-pricing.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add New House Pricing</a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($housePricings->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No house pricing found. Start by adding a new house pricing.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Type</th>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Total Price</th>
                            <th class="py-3 px-4 text-left">Deposit</th>
                            <th class="py-3 px-4 text-left">Balance</th>
                            <th class="py-3 px-4 text-left">Availability</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($housePricings as $pricing)
                        <tr>
                            <td class="py-3 px-4">{{ $pricing->house_type }}</td>
                            <td class="py-3 px-4">{{ $pricing->name }}</td>
                            <td class="py-3 px-4">{{ number_format($pricing->total_price, 2) }}</td>
                            <td class="py-3 px-4">{{ number_format($pricing->deposit_amount, 2) }}</td>
                            <td class="py-3 px-4">{{ number_format($pricing->balance_amount, 2) }}</td>
                            <td class="py-3 px-4">
                                @if($pricing->is_available)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Available</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Not Available</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.house-pricing.edit', $pricing) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                                <form method="POST" action="{{ route('admin.house-pricing.destroy', $pricing) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this pricing?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $housePricings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection