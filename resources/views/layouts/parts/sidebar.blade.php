<aside x-data="{ open: false }" class="z-50">
    <!-- Mobile Toggle -->
    <div class="lg:hidden fixed bottom-6 end-6 z-50">
        <button @click="open = !open" class="p-4 bg-emerald-600 text-white rounded-full shadow-2xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <!-- Sidebar Container -->
    <div :class="open ? 'translate-x-0' : (document.dir === 'rtl' ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0')" 
         class="fixed inset-y-0 start-0 w-72 m-6 bg-slate-900 rounded-[2.5rem] shadow-2xl transition-transform duration-300 ease-in-out flex flex-col overflow-hidden border border-slate-800">
        
        <!-- Logo Section -->
        <div class="p-8">
            <a href="/" class="flex items-center gap-4">
                <div class="p-3 bg-emerald-600 rounded-2xl shadow-lg shadow-emerald-900/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <span class="text-2xl font-black text-white tracking-tight">MediSync</span>
            </a>
        </div>

        <!-- Quick Action Button -->
        <div class="px-6 mb-8">
            <a href="{{ route('appointments.index') }}" class="w-full flex items-center justify-center gap-3 py-4 bg-gradient-to-r from-emerald-400 to-teal-500 text-white font-black rounded-2xl shadow-xl shadow-emerald-900/20 hover:scale-[1.02] transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                {{ __('messages.new_appointment') }}
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto custom-scrollbar">
            @if(auth()->user()->role === 'doctor')
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="m10 19-7-7m0 0 7-7m-7 7h18">
                    {{ __('messages.dashboard') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    {{ __('messages.appointments') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('services.index')" :active="request()->routeIs('services.*')" icon="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    {{ __('messages.services') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('patients.index')" :active="request()->routeIs('patients.*')" icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.123-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    {{ __('messages.patients') }}
                </x-sidebar-link>
            @else
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="m10 19-7-7m0 0 7-7m-7 7h18">
                    {{ __('messages.my_appointments') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('patient.book')" :active="request()->routeIs('patient.book')" icon="M12 4v1m0 11v1m5-10v1m0 10v1M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    {{ __('messages.book_appointment') }}
                </x-sidebar-link>
            @endif

            <div class="pt-4 mt-4 border-t border-slate-800/50">
                <x-sidebar-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                    {{ __('messages.settings') }}
                </x-sidebar-link>
            </div>
        </nav>

        <!-- User Profile Bottom Section -->
        <div class="p-6 bg-slate-800/50 mt-auto border-t border-slate-800">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate">{{ Auth::user()->role }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-700/50 hover:bg-rose-600/20 hover:text-rose-400 text-slate-300 rounded-xl font-bold transition-all group">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    {{ __('messages.logout') }}
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
</style>
