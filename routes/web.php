<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MeetingRequestController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\HousePricingController;
use App\Http\Controllers\Admin\ProjectProgressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');

// Authentication routes (already provided by Laravel Breeze)
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // Check if user is admin and redirect accordingly
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Meeting request routes - MOVED THESE BEFORE THE GENERAL MEETING ROUTES
    Route::get('/meetings/request', [MeetingRequestController::class, 'create'])->name('meetings.request');
    Route::post('/meetings/request', [MeetingRequestController::class, 'store'])->name('meetings.request.store');
    
    // Meeting routes for regular users
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/meetings/create', [MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/meetings/{meeting}', [MeetingController::class, 'show'])->name('meetings.show');
    Route::delete('/meetings/{meeting}', [MeetingController::class, 'cancel'])->name('meetings.cancel');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Location management (new)
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    
    // Service management
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'deleteService'])->name('services.delete');
    
    // Service category management
    Route::get('/service-categories', [AdminController::class, 'serviceCategories'])->name('service-categories');
    Route::get('/service-categories/create', [AdminController::class, 'createServiceCategory'])->name('service-categories.create');
    Route::post('/service-categories', [AdminController::class, 'storeServiceCategory'])->name('service-categories.store');
    Route::get('/service-categories/{category}/edit', [AdminController::class, 'editServiceCategory'])->name('service-categories.edit');
    Route::put('/service-categories/{category}', [AdminController::class, 'updateServiceCategory'])->name('service-categories.update');
    Route::delete('/service-categories/{category}', [AdminController::class, 'deleteServiceCategory'])->name('service-categories.delete');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    
    // Meeting management
    Route::get('/meetings', [AdminMeetingController::class, 'index'])->name('meetings.index');
    Route::get('/meetings/{meeting}', [AdminMeetingController::class, 'show'])->name('meetings.show');
    Route::put('/meetings/{meeting}', [AdminMeetingController::class, 'update'])->name('meetings.update');
    
    // Meeting request management (new)
    Route::get('/meeting-requests', [AdminMeetingController::class, 'requests'])->name('meetings.requests');
    Route::get('/meeting-requests/{meeting}/process', [AdminMeetingController::class, 'processRequest'])->name('meetings.process-request');
    Route::put('/meeting-requests/{meeting}', [AdminMeetingController::class, 'updateRequest'])->name('meetings.update-request');
    
    // Time slot management
    Route::get('/time-slots', [AdminMeetingController::class, 'timeSlots'])->name('meetings.time-slots');
    Route::get('/time-slots/create', [AdminMeetingController::class, 'createTimeSlot'])->name('meetings.create-time-slot');
    Route::post('/time-slots', [AdminMeetingController::class, 'storeTimeSlot'])->name('meetings.store-time-slot');
    Route::delete('/time-slots/{timeSlot}', [AdminMeetingController::class, 'deleteTimeSlot'])->name('meetings.delete-time-slot');
    
    // Batch time slots (new)
    Route::get('/time-slots/batch', [AdminMeetingController::class, 'batchTimeSlots'])->name('meetings.batch-time-slots');
    Route::post('/time-slots/batch', [AdminMeetingController::class, 'storeBatchTimeSlots'])->name('meetings.store-batch-time-slots');
    
    // House pricing management
    Route::get('/house-pricing', [HousePricingController::class, 'index'])->name('house-pricing.index');
    Route::get('/house-pricing/create', [HousePricingController::class, 'create'])->name('house-pricing.create');
    Route::post('/house-pricing', [HousePricingController::class, 'store'])->name('house-pricing.store');
    Route::get('/house-pricing/{housePricing}/edit', [HousePricingController::class, 'edit'])->name('house-pricing.edit');
    Route::put('/house-pricing/{housePricing}', [HousePricingController::class, 'update'])->name('house-pricing.update');
    Route::delete('/house-pricing/{housePricing}', [HousePricingController::class, 'destroy'])->name('house-pricing.destroy');
    
    // Project progress management
    Route::get('/projects', [ProjectProgressController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectProgressController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectProgressController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectProgressController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectProgressController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectProgressController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectProgressController::class, 'destroy'])->name('projects.destroy');
    
    // Project progress updates
    Route::get('/projects/{project}/updates/create', [ProjectProgressController::class, 'createUpdate'])->name('projects.updates.create');
    Route::post('/projects/{project}/updates', [ProjectProgressController::class, 'storeUpdate'])->name('projects.updates.store');
    Route::get('/projects/updates/{update}/edit', [ProjectProgressController::class, 'editUpdate'])->name('projects.updates.edit');
    Route::put('/projects/updates/{update}', [ProjectProgressController::class, 'updateUpdate'])->name('projects.updates.update');
    Route::delete('/projects/updates/{update}', [ProjectProgressController::class, 'destroyUpdate'])->name('projects.updates.destroy');
});