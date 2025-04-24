<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousePricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HousePricingController extends Controller
{
    public function index()
    {
        $housePricings = HousePricing::paginate(10);
        return view('admin.house-pricing.index', compact('housePricings'));
    }
    
    public function create()
    {
        return view('admin.house-pricing.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'house_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0|lte:total_price',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'nullable',
        ]);
        
        $data = $request->except('image');
        $data['is_available'] = $request->has('is_available');
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('house-pricing', 'public');
            $data['image'] = $path;
        }
        
        // Calculate balance amount
        $data['balance_amount'] = $data['total_price'] - $data['deposit_amount'];
        
        HousePricing::create($data);
        
        return redirect()->route('admin.house-pricing.index')->with('success', 'House pricing created successfully.');
    }
    
    public function edit(HousePricing $housePricing)
    {
        return view('admin.house-pricing.edit', compact('housePricing'));
    }
    
    public function update(Request $request, HousePricing $housePricing)
    {
        $request->validate([
            'house_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0|lte:total_price',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'nullable',
        ]);
        
        $data = $request->except('image');
        $data['is_available'] = $request->has('is_available');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($housePricing->image) {
                Storage::disk('public')->delete($housePricing->image);
            }
            
            $path = $request->file('image')->store('house-pricing', 'public');
            $data['image'] = $path;
        }
        
        // Calculate balance amount
        $data['balance_amount'] = $data['total_price'] - $data['deposit_amount'];
        
        $housePricing->update($data);
        
        return redirect()->route('admin.house-pricing.index')->with('success', 'House pricing updated successfully.');
    }
    
    public function destroy(HousePricing $housePricing)
    {
        // Delete image if exists
        if ($housePricing->image) {
            Storage::disk('public')->delete($housePricing->image);
        }
        
        $housePricing->delete();
        
        return redirect()->route('admin.house-pricing.index')->with('success', 'House pricing deleted successfully.');
    }
}