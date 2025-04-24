@extends('layouts.main')

@section('title', 'About Us')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1513467535987-fd81bc7d62f8?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1489&q=80" alt="Construction Team" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">About Us</h1>
                <p class="mt-6 text-xl max-w-3xl mx-auto">Learn about our company's mission, vision, and the team that makes it all possible.</p>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Section -->
    <div class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <div class="bg-gray-50 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-gray-600">
                        At NusaTrack, our mission is to revolutionize the construction management industry by providing 
                        transparent, efficient, and client-focused solutions. We aim to bridge the gap between clients 
                        and construction teams through innovative technology that ensures clear communication, real-time 
                        updates, and streamlined processes, ultimately delivering exceptional value and satisfaction 
                        to our clients.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h2>
                    <p class="text-gray-600">
                        We envision a future where construction project management is seamless, transparent, and 
                        stress-free for all stakeholders. NusaTrack aims to be the leading platform that transforms 
                        traditional construction management into a modern, digital experience, setting new industry 
                        standards for client satisfaction, project efficiency, and technological innovation in Indonesia 
                        and beyond.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Company History -->
    <div class="bg-gray-50 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Our Journey</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">How NusaTrack evolved from an idea to a leading construction management platform.</p>
            </div>
            
            <div class="relative">
                <!-- Timeline Line -->
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gray-200"></div>
                
                <!-- Timeline Items -->
                <div class="space-y-12">
                    <!-- 2018 -->
                    <div class="relative">
                        <div class="md:flex items-center md:space-x-12">
                            <div class="md:w-1/2 md:text-right mb-4 md:mb-0">
                                <div class="bg-white p-6 rounded-lg shadow-md inline-block">
                                    <h3 class="text-lg font-medium text-gray-900">2018: The Beginning</h3>
                                    <p class="mt-2 text-gray-600">NusaTrack was founded with a vision to modernize construction management in Indonesia.</p>
                                </div>
                            </div>
                            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-indigo-600 border-4 border-white"></div>
                            <div class="md:w-1/2"></div>
                        </div>
                    </div>
                    
                    <!-- 2019 -->
                    <div class="relative">
                        <div class="md:flex items-center md:space-x-12">
                            <div class="md:w-1/2"></div>
                            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-indigo-600 border-4 border-white"></div>
                            <div class="md:w-1/2 mb-4 md:mb-0">
                                <div class="bg-white p-6 rounded-lg shadow-md inline-block">
                                    <h3 class="text-lg font-medium text-gray-900">2019: First Platform Launch</h3>
                                    <p class="mt-2 text-gray-600">We launched our first version of the platform, focusing on basic project tracking and communication.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2020 -->
                    <div class="relative">
                        <div class="md:flex items-center md:space-x-12">
                            <div class="md:w-1/2 md:text-right mb-4 md:mb-0">
                                <div class="bg-white p-6 rounded-lg shadow-md inline-block">
                                    <h3 class="text-lg font-medium text-gray-900">2020: Expansion</h3>
                                    <p class="mt-2 text-gray-600">Grew our team and expanded services to include more comprehensive construction management features.</p>
                                </div>
                            </div>
                            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-indigo-600 border-4 border-white"></div>
                            <div class="md:w-1/2"></div>
                        </div>
                    </div>
                    
                    <!-- 2022 -->
                    <div class="relative">
                        <div class="md:flex items-center md:space-x-12">
                            <div class="md:w-1/2"></div>
                            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-indigo-600 border-4 border-white"></div>
                            <div class="md:w-1/2 mb-4 md:mb-0">
                                <div class="bg-white p-6 rounded-lg shadow-md inline-block">
                                    <h3 class="text-lg font-medium text-gray-900">2022: Digital Transformation</h3>
                                    <p class="mt-2 text-gray-600">Implemented advanced digital solutions including real-time updates and secure payment gateways.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2023 -->
                    <div class="relative">
                        <div class="md:flex items-center md:space-x-12">
                            <div class="md:w-1/2 md:text-right mb-4 md:mb-0">
                                <div class="bg-white p-6 rounded-lg shadow-md inline-block">
                                    <h3 class="text-lg font-medium text-gray-900">2023: Regional Leader</h3>
                                    <p class="mt-2 text-gray-600">Became one of the leading construction management platforms in Indonesia with clients across the country.</p>
                                </div>
                            </div>
                            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-indigo-600 border-4 border-white"></div>
                            <div class="md:w-1/2"></div>
                        </div>
                    </div>
                    
                    <!-- Today -->
                    <div class="relative">
                        <div class="md:flex items-center md:space-x-12">
                            <div class="md:w-1/2"></div>
                            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-indigo-600 border-4 border-white"></div>
                            <div class="md:w-1/2 mb-4 md:mb-0">
                                <div class="bg-white p-6 rounded-lg shadow-md inline-block">
                                    <h3 class="text-lg font-medium text-gray-900">Today: Continuous Innovation</h3>
                                    <p class="mt-2 text-gray-600">Continuously enhancing our platform with new features and improvements based on client feedback and industry trends.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Meet Our Team</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">The dedicated professionals behind NusaTrack's success.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($team_members as $member)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-lg">
                        <div class="h-48 bg-gray-200">
                            @if(isset($member['image']))
                                <img src="{{ asset('images/' . $member['image']) }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-4xl text-indigo-800 font-medium">{{ substr($member['name'], 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ $member['name'] }}</h3>
                            <p class="text-indigo-600">{{ $member['position'] }}</p>
                            <p class="mt-3 text-gray-600">{{ $member['bio'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white">Ready to work with us?</h2>
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