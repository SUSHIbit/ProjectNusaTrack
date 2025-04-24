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
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center h-16 px-6 bg-gray-900">
                <span class="text-xl font-semibold text-white">NusaTrack Admin</span>
            </div>
            <nav class="mt-5 px-3">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-white rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Dashboard</span>
                </a>
                <a href="{{ route('admin.meetings.index') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md {{ request()->routeIs('admin.meetings.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Meetings</span>
                </a>
                <a href="{{ route('admin.meetings.time-slots') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md {{ request()->routeIs('admin.meetings.time-slots') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Time Slots</span>
                </a>
                <a href="{{ route('admin.services') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md {{ request()->routeIs('admin.services*') && !request()->routeIs('admin.service-categories*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Services</span>
                </a>
                <a href="{{ route('admin.service-categories') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md {{ request()->routeIs('admin.service-categories*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Service Categories</span>
                </a>
                <a href="{{ route('admin.users') }}" class="group flex items-center px-4 py-2 mt-1 text-white rounded-md {{ request()->routeIs('admin.users*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <span class="ml-4">Users</span>
                </a>
                
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

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top navbar -->
            <div class="bg-white h-16 flex items-center justify-between px-6 shadow">
                <div>
                    <button class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
                
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

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>