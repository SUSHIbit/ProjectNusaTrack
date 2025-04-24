@extends('layouts.main')

@section('title', 'Client Testimonials')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1572177812156-58036aae439c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1489&q=80" alt="Happy Clients" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">What Our Clients Say</h1>
                <p class="mt-6 text-xl max-w-3xl mx-auto">Don't just take our word for it. Here's what our clients have to say about their experience with NusaTrack.</p>
            </div>
        </div>
    </div>

    <!-- Testimonials Grid Section -->
    <div class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($testimonials as $testimonial)
                    <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                        <div class="flex items-center mb-4">
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
                        
                        <div class="mb-4">
                            <div class="flex">
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
                        </div>
                        
                        <div class="italic text-gray-600">
                            <p>{{ $testimonial->content }}</p>
                        </div>
                        
                        @if($testimonial->project_name)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-500">Project: <span class="font-medium">{{ $testimonial->project_name }}</span></p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No Testimonials Yet</h3>
                        <p class="mt-1 text-gray-500">We're collecting feedback from our clients. Check back soon!</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($testimonials->hasPages())
                <div class="mt-12">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white">Join our satisfied clients</h2>
                <p class="mt-4 text-xl text-indigo-100">Start your construction journey with NusaTrack today.</p>
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection