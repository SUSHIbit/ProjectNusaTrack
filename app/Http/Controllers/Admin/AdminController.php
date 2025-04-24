<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMeetings = Meeting::count();
        $pendingMeetings = Meeting::where('status', 'pending')->count();
        $services = Service::count();
        
        $recentMeetings = Meeting::with('user')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalMeetings', 
            'pendingMeetings', 
            'services', 
            'recentMeetings'
        ));
    }
    
    // Service Management
    public function services()
    {
        $services = Service::with('category')->paginate(15);
        return view('admin.services.index', compact('services'));
    }
    
    public function createService()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }
    
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category_id' => 'required|exists:service_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }
        
        Service::create($data);
        
        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
    }
    
    public function editService(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }
    
    public function updateService(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category_id' => 'required|exists:service_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }
        
        $service->update($data);
        
        return redirect()->route('admin.services')->with('success', 'Service updated successfully.');
    }
    
    public function deleteService(Service $service)
    {
        // Delete image if exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();
        
        return redirect()->route('admin.services')->with('success', 'Service deleted successfully.');
    }
    
    // Service Category Management
    public function serviceCategories()
    {
        $categories = ServiceCategory::withCount('services')->paginate(15);
        return view('admin.services.categories', compact('categories'));
    }
    
    public function createServiceCategory()
    {
        return view('admin.services.create_category');
    }
    
    public function storeServiceCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        ServiceCategory::create($request->all());
        
        return redirect()->route('admin.service-categories')->with('success', 'Service category created successfully.');
    }
    
    public function editServiceCategory(ServiceCategory $category)
    {
        return view('admin.services.edit_category', compact('category'));
    }
    
    public function updateServiceCategory(Request $request, ServiceCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $category->update($request->all());
        
        return redirect()->route('admin.service-categories')->with('success', 'Service category updated successfully.');
    }
    
    public function deleteServiceCategory(ServiceCategory $category)
    {
        // Check if category has services
        if ($category->services()->count() > 0) {
            return back()->withErrors(['category' => 'Cannot delete a category that has services.']);
        }
        
        $category->delete();
        
        return redirect()->route('admin.service-categories')->with('success', 'Service category deleted successfully.');
    }
    
    // User Management
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    public function showUser(User $user)
    {
        $meetings = $user->meetings()->orderBy('meeting_date', 'desc')->get();
        return view('admin.users.show', compact('user', 'meetings'));
    }
}