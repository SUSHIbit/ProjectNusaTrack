@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1489&q=80" alt="Construction Site" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">NusaTrack</h1>
                <p class="mt-6 text-xl">Streamlined construction management for the modern era. Track your project from planning to completion with ease.</p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="inline-block bg-indigo-600 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-indigo-700">Get Started</a>
                    <a href="{{ route('services') }}" class="inline-block ml-4 bg-transparent border border-white rounded-md py-3 px-8 font-medium text-white hover:bg-white hover:text-gray-900">Our Services</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Why Choose NusaTrack?</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Experience the future of construction management with our comprehensive platform.</p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Real-time Progress Tracking</h3>
                        <p class="mt-2 text-gray-500">Stay updated with your construction progress through our real-time tracking system.</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Streamlined Communication</h3>
                        <p class="mt-2 text-gray-500">Direct communication with our team through an integrated chat system.</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="w-12 h-12 rounded-md bg-indigo-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Secure Payments</h3>
                        <p class="mt-2 text-gray-500">Make secure online payments through our trusted payment gateway.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Preview Section -->
    <div class="bg-gray-50 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Our Services</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">We offer a wide range of construction services tailored to your needs.</p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($services as $service)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ $service->name }}</h3>
                            <p class="mt-2 text-gray-500">{{ Str::limit($service->description, 100) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500">No services available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('services') }}" class="inline-block bg-indigo-600 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-indigo-700">View All Services</a>
            </div>
        </div>
    </div>

    <!-- Testimonials Preview Section -->
    <div class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">What Our Clients Say</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Hear from our satisfied clients about their experience with NusaTrack.</p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($testimonials as $testimonial)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center">
                                @if($testimonial->client_image)
                                    <img src="{{ asset('storage/' . $testimonial->client_image) }}" alt="{{ $testimonial->client_name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-800 font-medium">{{ substr($testimonial->client_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $testimonial->client_name }}</h3>
                                    @if($testimonial->client_position)
                                        <p class="text-sm text-gray-500">{{ $testimonial->client_position }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-gray-600">{{ Str::limit($testimonial->content, 150) }}</p>
                                @if($testimonial->project_name)
                                    <p class="mt-2 text-sm text-gray-500">Project: {{ $testimonial->project_name }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8">
                            <p class="text-gray-500">No testimonials available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('testimonials') }}" class="inline-block bg-indigo-600 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-indigo-700">View All Testimonials</a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Ready to start your construction project?</h2>
            <p class="mt-4 text-xl text-indigo-100">Register today and experience the difference with NusaTrack.</p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="inline-block bg-white border border-transparent rounded-md py-3 px-8 font-medium text-indigo-700 hover:bg-indigo-50">Sign Up Now</a>
            </div>
        </div>
    </div>
@endsection