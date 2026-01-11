<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'" 
    class="bg-white border-r border-gray-200 min-h-screen transition-all duration-300 ease-in-out flex flex-col fixed md:relative z-30 hidden md:flex"
>
    <div class="h-16 flex items-center justify-center border-b border-gray-100">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-2 px-2">
            
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center p-2 rounded-lg group {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        
                        <span :class="sidebarOpen ? 'block' : 'hidden'" class="ml-3 font-medium whitespace-nowrap">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.events.index') }}" 
                       class="flex items-center p-2 rounded-lg group {{ request()->routeIs('admin.events.*') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        
                        <span :class="sidebarOpen ? 'block' : 'hidden'" class="ml-3 font-medium whitespace-nowrap">Kelola Acara</span>
                    </a>
                </li>

            @else
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center p-2 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        
                        <span :class="sidebarOpen ? 'block' : 'hidden'" class="ml-3 font-medium whitespace-nowrap">Beranda</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('biodata.edit') }}" 
                       class="flex items-center p-2 rounded-lg group {{ request()->routeIs('biodata.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        
                        <span :class="sidebarOpen ? 'block' : 'hidden'" class="ml-3 font-medium whitespace-nowrap">Biodata Saya</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>

    <div class="p-4 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full p-2 text-gray-600 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors group">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span :class="sidebarOpen ? 'block' : 'hidden'" class="ml-3 font-medium whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>

<div x-show="!sidebarOpen" @click="sidebarOpen = true" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" style="display: none;"></div>
<aside 
    x-show="sidebarOpen" 
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 md:hidden overflow-y-auto"
    style="display: none;"
>
   <div class="h-16 flex items-center justify-center border-b border-gray-100">
        <span class="font-bold text-lg">Menu</span>
    </div>
    <nav class="py-4 px-2 space-y-2">
        <a href="{{ route('dashboard') }}" class="block p-2 rounded text-gray-700 hover:bg-gray-100">Dashboard</a>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.events.index') }}" class="block p-2 rounded text-gray-700 hover:bg-gray-100">Kelola Acara</a>
        @else
            <a href="{{ route('biodata.edit') }}" class="block p-2 rounded text-gray-700 hover:bg-gray-100">Biodata</a>
        @endif
    </nav>
</aside>