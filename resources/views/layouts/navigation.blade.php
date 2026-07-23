<!-- Backdrop -->
<div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 dark:bg-gray-900 dark:border-gray-800 flex flex-col">
    
    <!-- Logo Area -->
    <div class="flex items-center h-16 border-b border-gray-200 dark:border-gray-800 px-6 shrink-0 justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 overflow-hidden">
            @if(\App\Models\Setting::get('app_logo'))
                <img src="{{ Storage::url(\App\Models\Setting::get('app_logo')) }}" alt="Logo" class="block h-10 w-auto object-contain shrink-0" />
            @else
                <x-application-logo class="block h-8 w-auto fill-current text-blue-600 dark:text-blue-400 shrink-0" />
                <span class="font-bold text-lg text-gray-900 dark:text-white truncate">
                    {{ \App\Models\Setting::get('app_name', 'RiskManager') }}
                </span>
            @endif
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        
        @php
            $navItems = [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'permission' => null],
                ['name' => 'Mapa de Calor', 'route' => 'heatmap', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'permission' => 'ver riscos'],
                ['name' => 'Riscos', 'route' => 'risks.index', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'permission' => 'ver riscos'],
                ['name' => 'Planos de Ação', 'route' => 'action-plans.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'permission' => 'ver planos'],
                ['name' => 'Relatórios', 'route' => 'reports.index', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'permission' => null],
                ['name' => 'Utilizadores', 'route' => 'users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'permission' => 'gerir utilizadores'],
                ['name' => 'Perfis e Acessos', 'route' => 'roles.index', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'permission' => 'gerir utilizadores'],
                ['name' => 'Configurações', 'route' => 'settings.index', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'permission' => 'gerir configuracoes'],
            ];
        @endphp

        @foreach($navItems as $item)
            @if(!$item['permission'] || Auth::user()->can($item['permission']))
                @php
                    $isActive = request()->routeIs($item['route']) || (str_ends_with($item['route'], '.index') && request()->routeIs(str_replace('.index', '.*', $item['route'])));
                @endphp
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-blue-700 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                    </svg>
                    {{ $item['name'] }}
                </a>
            @endif
        @endforeach

    </nav>
    
    <!-- User Footer inside Sidebar -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-800 shrink-0">
        <div class="flex items-center gap-3">
            @if(Auth::user()->avatar)
                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-700">
            @else
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 flex items-center justify-center font-bold shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <div class="overflow-hidden">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
