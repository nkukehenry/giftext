<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Add these lines in the <head> section of your layout or at the top of participants.blade.php -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />

</head>

<body class="bg-gray-100">
    <div id="app" class="flex flex-col">
        <!-- Navigation Bar -->
        <nav class="flex items-center justify-center flex-wrap bg-santa-maroon py-2 px-4 sticky top-0 z-50">
            <div class="flex items-center flex-shrink-0 text-santa-white mr-6">
                <a href="{{ url('/') }}" class="font-semibold text-lg tracking-tight">{{ config('app.name', 'Santa App') }}</a>
            </div>
            
            <div class="flex items-center space-x-4" x-data="{ open: false }">
                <div class="block lg:hidden">
                    <button @click="open = !open" class="flex items-center px-3 py-2 border rounded text-santa-white border-santa-white hover:text-santa-gold hover:border-santa-gold">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                    </button>
                </div>

                <div class="hidden lg:flex lg:items-center lg:w-auto">
                    <div class="text-sm lg:flex-grow flex justify-center space-x-4">
                        <a href="{{ route('admin.participants') }}" class="block mt-2 lg:inline-block lg:mt-0 text-santa-white hover:text-santa-gold">
                            <i class="fas fa-users mr-2"></i> Participants
                        </a>
                        <a href="{{ route('admin.groups') }}" class="block mt-2 lg:inline-block lg:mt-0 text-santa-white hover:text-santa-gold">
                            <i class="fas fa-th mr-2"></i> Groupings
                        </a>
                        <a href="{{ route('admin.reports') }}" class="block mt-2 lg:inline-block lg:mt-0 text-santa-white hover:text-santa-gold">
                            <i class="fas fa-chart-line mr-2"></i> Reports
                        </a>
                        <a href="{{ route('admin.users') }}" class="block mt-2 lg:inline-block lg:mt-0 text-santa-white hover:text-santa-gold">
                            <i class="fas fa-users-cog mr-2"></i> Users
                        </a>
                        <a href="{{ route('admin.settings') }}" class="block mt-2 lg:inline-block lg:mt-0 text-santa-white hover:text-santa-gold">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                    </div>
                </div>

                @auth
                    <div class="relative flex items-center">
                        <button @click="open = !open" class="focus:outline-none">
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full border-2 bg-white border-santa-gold" />
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                                @csrf
                                <button type="submit" class="w-full text-left text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            <div class="container mx-auto px-4">
                <x-alert type="success" message="success" />
                <x-alert type="error" message="error" />
                <x-alert type="info" message="info" />
                <x-alert type="warning" message="warning" />
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</body>
</html>
