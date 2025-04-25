<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name')->paginate(15);
        return view('admin.locations.index', compact('locations'));
    }
    
    public function create()
    {
        return view('admin.locations.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
            'is_active' => 'boolean',
        ]);
        
        Location::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('admin.locations.index')->with('success', 'Location created successfully');
    }
    
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }
    
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'is_active' => 'boolean',
        ]);
        
        $location->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully');
    }
    
    public function destroy(Location $location)
    {
        // Check if the location has any associated meetings
        if ($location->meetings()->count() > 0) {
            return redirect()->route('admin.locations.index')->with('error', 'This location cannot be deleted because it has associated meetings');
        }
        
        $location->delete();
        
        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully');
    }
}