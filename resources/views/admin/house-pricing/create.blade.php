@extends('layouts.admin')

@section('title', 'Add House Pricing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.house-pricing.index') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to House Pricing
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Add House Pricing</h1>
    </div>
    
    @if($errors->any())
        <div class="mb-4 bg-red-100 p-4 rounded text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.house-pricing.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="house_type" class="block text-gray-700 font-medium mb-2">House Type</label>
                <input type="text" id="house_type" name="house_type" value="{{ old('house_type') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required placeholder="e.g., Single Family, Townhouse, Apartment">
            </div>
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required placeholder="e.g., Modern Villa Type A">
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Detailed description of the house...">{{ old('description') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="total_price" class="block text-gray-700 font-medium mb-2">Total Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" id="total_price" name="total_price" value="{{ old('total_price') }}" step="0.01" min="0" class="w-full pl-8 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                
                <div>
                    <label for="deposit_amount" class="block text-gray-700 font-medium mb-2">Deposit Amount</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" id="deposit_amount" name="deposit_amount" value="{{ old('deposit_amount') }}" step="0.01" min="0" class="w-full pl-8 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">The balance will be calculated automatically.</p>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">House Image (Optional)</label>
                <input type="file" id="image" name="image" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Upload an image of the house (max 2MB).</p>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available') ? 'checked' : '' }} class="border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="is_available" class="ml-2 text-gray-700 font-medium">Available for Purchase</label>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.house-pricing.index') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create House Pricing</button>
            </div>
        </form>
    </div>
</div>
@endsection