<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - NusaTrack Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-col md:fixed md:inset-y-0 md:w-64 bg-gray-800 overflow-y-auto">
            <div class="flex items-center justify-center h-16 px-6 bg-gray-900">
                <span class="text-xl font-semibold text-white">NusaTrack Admin</span>
            </div>
            <nav class="mt-5 px-3 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Dashboard</span>
                </a>
                
                <!-- Meeting Management Section -->
                <div class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Meeting Management
                    </h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.meetings.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.meetings.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">All Meetings</span>
                        </a>
                        <a href="{{ route('admin.meetings.requests') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.meetings.requests') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Meeting Requests</span>
                        </a>
                        <a href="{{ route('admin.meetings.time-slots') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.meetings.time-slots') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Time Slots</span>
                        </a>
                        <a href="{{ route('admin.locations.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.locations.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Locations</span>
                        </a>
                    </div>
                </div>
                
                <!-- Service Management Section -->
                <div class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Service Management
                    </h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.services') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.services*') && !request()->routeIs('admin.service-categories*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Services</span>
                        </a>
                        <a href="{{ route('admin.service-categories') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.service-categories*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Service Categories</span>
                        </a>
                    </div>
                </div>
                
                <!-- Project Management Section -->
                <div class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Project Management
                    </h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.house-pricing.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.house-pricing.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">House Pricing</span>
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.projects.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Project Progress</span>
                        </a>
                    </div>
                </div>
                
                <!-- User Management Section -->
                <div class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        User Management
                    </h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.users') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.users*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                            <span class="ml-4">Users</span>
                        </a>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 my-4"></div>
                
                <a href="{{ route('home') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md hover:bg-gray-700">
                    <span class="ml-4">Back to Website</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-white rounded-md hover:bg-gray-700">
                        <span class="ml-4">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Mobile menu button, mobile menu and backdrop -->
        <div class="md:hidden">
            <div x-data="{ open: false }">
                <!-- Mobile menu button -->
                <button @click="open = !open" class="fixed top-4 left-4 z-40 text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>

                <!-- Mobile menu and backdrop -->
                <div x-show="open" class="fixed inset-0 z-30 flex">
                    <div @click="open = false" x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                    
                    <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button @click="open = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="sr-only">Close sidebar</span>
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                            <div class="flex-shrink-0 flex items-center px-4">
                                <span class="text-xl font-semibold text-white">NusaTrack Admin</span>
                            </div>
                            <nav class="mt-5 px-3 space-y-1">
                                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                    <span class="ml-4">Dashboard</span>
                                </a>
                                
                                <!-- Meeting Management Section -->
                                <div class="mt-4">
                                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Meeting Management
                                    </h3>
                                    <div class="mt-2 space-y-1">
                                        <a href="{{ route('admin.meetings.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.meetings.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">All Meetings</span>
                                        </a>
                                        <a href="{{ route('admin.meetings.requests') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.meetings.requests') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Meeting Requests</span>
                                        </a>
                                        <a href="{{ route('admin.meetings.time-slots') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.meetings.time-slots') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Time Slots</span>
                                        </a>
                                        <a href="{{ route('admin.locations.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.locations.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Locations</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Service Management Section -->
                                <div class="mt-4">
                                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Service Management
                                    </h3>
                                    <div class="mt-2 space-y-1">
                                        <a href="{{ route('admin.services') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.services*') && !request()->routeIs('admin.service-categories*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Services</span>
                                        </a>
                                        <a href="{{ route('admin.service-categories') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.service-categories*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Service Categories</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Project Management Section -->
                                <div class="mt-4">
                                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Project Management
                                    </h3>
                                    <div class="mt-2 space-y-1">
                                        <a href="{{ route('admin.house-pricing.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.house-pricing.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">House Pricing</span>
                                        </a>
                                        <a href="{{ route('admin.projects.index') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.projects.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Project Progress</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- User Management Section -->
                                <div class="mt-4">
                                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        User Management
                                    </h3>
                                    <div class="mt-2 space-y-1">
                                        <a href="{{ route('admin.users') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.users*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                                            <span class="ml-4">Users</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-700 my-4"></div>
                                
                                <a href="{{ route('home') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md hover:bg-gray-700">
                                    <span class="ml-4">Back to Website</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-white rounded-md hover:bg-gray-700">
                                        <span class="ml-4">Logout</span>
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="flex-shrink-0 w-14">
                        <!-- Force sidebar to shrink to fit close icon -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- Top navbar -->
            <div class="bg-white h-16 flex items-center justify-between px-6 shadow z-10">
                <div class="md:hidden">
                    <!-- Placeholder for mobile menu button -->
                </div>
                
                <div class="flex-1 flex justify-end">
                    <div class="flex items-center">
                        <div class="relative">
                            <div class="flex items-center cursor-pointer">
                                <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                    {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'A' }}
                                </div>
                                <span class="ml-2">{{ auth()->user() ? auth()->user()->name : 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>