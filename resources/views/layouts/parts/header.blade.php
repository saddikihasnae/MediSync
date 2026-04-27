<header class="bg-white/80 backdrop-blur-md sticky top-0 z-30 px-8 py-5 flex justify-between items-center">
    <!-- Left: Page Title -->
    <div class="flex items-center gap-6">
        <!-- Mobile Sidebar Toggle (Visible on mobile) -->
        <button class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">@yield('title', 'Overview')</h2>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">{{ date('l, d M Y') }}</p>
        </div>
    </div>

    <!-- Right: Search, Notifications, Profile -->
    <div class="flex items-center gap-8">
        <!-- Search Bar (Desktop) -->
        <div class="hidden md:flex relative group">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" placeholder="{{ __('messages.search') }}" class="bg-slate-100/50 border-none rounded-2xl py-3 pl-12 pr-6 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white transition-all w-64">
        </div>

        <!-- Notifications -->
        <button class="relative p-2.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-2xl transition-all group">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
        </button>

        <div class="h-8 w-px bg-slate-100"></div>

        <!-- User Dropdown -->
        <x-dropdown align="{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" width="56">
            <x-slot name="trigger">
                <button class="flex items-center gap-4 group focus:outline-none">
                    <div class="text-end hidden sm:block">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">{{ Auth::user()->role === 'doctor' ? 'Clinic Admin' : 'Patient' }}</p>
                        <p class="text-sm font-black text-slate-800 group-hover:text-emerald-600 transition-colors">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-black shadow-sm group-hover:scale-105 transition-all">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 border-b border-slate-50">
                    <p class="text-xs font-bold text-slate-400 mb-1">Logged in as</p>
                    <p class="text-sm font-black text-slate-800 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <x-dropdown-link :href="route('profile.edit')" class="font-bold text-slate-600 py-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('messages.settings') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 font-bold py-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        {{ __('messages.logout') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
