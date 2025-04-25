@extends('layouts.main')

@section('title', 'Our Services')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1489&q=80" alt="Construction Services" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">Our Services</h1>
                <p class="mt-6 text-xl max-w-3xl mx-auto">Comprehensive construction solutions tailored to your needs. Explore our range of services designed to make your construction project a success.</p>
                
                <!-- Added Request Meeting Button -->
                <div class="mt-8">
                    @auth
                        <a href="{{ route('meetings.request') }}" class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                            Request a Meeting
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                            Login to Request a Meeting
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Services Categories Section -->
    <div class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @forelse($categories as $category)
                <div class="mb-16 last:mb-0">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-2 border-b-2 border-indigo-500 inline-block">{{ $category->name }}</h2>
                    
                    @if($category->description)
                        <p class="text-lg text-gray-600 mb-8 max-w-4xl">{{ $category->description }}</p>
                    @endif
                    
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse($category->services as $service)
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $service->name }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $service->description }}</p>
                                    @auth
                                        <div class="mt-4 flex space-x-2">
                                            <a href="{{ route('meetings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                                Book a Meeting
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-4">
                                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                                Login to Book
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3">
                                <p class="text-gray-500 text-center py-8">No services available in this category at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No Service Categories</h3>
                    <p class="mt-1 text-gray-500">We're currently updating our services. Please check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="bg-gray-50 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Why Choose Our Services</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">What sets NusaTrack apart from other construction management solutions.</p>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Efficient Process</h3>
                    <p class="mt-2 text-gray-500">Our streamlined approach ensures your project is completed efficiently without compromising on quality.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Expert Team</h3>
                    <p class="mt-2 text-gray-500">Our team of experienced professionals brings expertise and dedication to every project.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Quality Assurance</h3>
                    <p class="mt-2 text-gray-500">We maintain the highest standards of quality in all aspects of our construction services.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Transparent Communication</h3>
                    <p class="mt-2 text-gray-500">We keep you informed throughout the entire process with real-time updates and clear communication.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white">Ready to start your project?</h2>
                <p class="mt-4 text-xl text-indigo-100">Get in touch with us to discuss your construction needs.</p>
                <div class="mt-8 flex justify-center">
                    @auth
                        <a href="{{ route('meetings.request') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                            Request a Meeting
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                            Register Now
                        </a>
                        <a href="{{ route('login') }}" class="ml-4 inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection