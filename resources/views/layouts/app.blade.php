<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Setting::get('app_name', config('app.name', 'Laravel')) }}</title>
        @if(\App\Models\Setting::get('app_favicon'))
            <link rel="icon" href="{{ Storage::url(\App\Models\Setting::get('app_favicon')) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=open-sans:300,400,500,600&display=swap" rel="stylesheet" />

        @livewireStyles
        <!-- Scripts -->
        <!-- CDNs -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class', // Disables OS-level dark mode
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 bg-gray-50 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-200" x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <!-- Topbar -->
                <header class="sticky top-0 z-30 flex items-center justify-between px-4 py-4 bg-white border-b border-gray-200 sm:px-6 lg:px-8 dark:bg-gray-900 dark:border-gray-800">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden dark:text-gray-400">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        
                        @isset($header)
                            <h2 class="ml-4 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 lg:ml-0">
                                {{ $header }}
                            </h2>
                        @endisset
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Removed Dark Mode Toggle -->

                        <!-- User Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover shrink-0 mr-2 border border-gray-200 dark:border-gray-700">
                                    @endif
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Perfil') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Terminar Sessão') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        @livewireScripts
        @stack('scripts')
    </body>
</html>
