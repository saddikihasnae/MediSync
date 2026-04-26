<header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30 px-8 py-4 flex justify-between items-center shadow-sm">
    <div class="flex items-center gap-4 lg:hidden">
        <button class="p-2 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <div class="hidden lg:block">
        <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
            <span class="text-slate-400">Pages</span>
            <span class="text-slate-200">/</span>
            <span>@yield('title', 'Overview')</span>
        </h2>
    </div>

    <div class="flex items-center gap-6">
        <div class="h-8 w-px bg-slate-100 hidden sm:block"></div>

        <!-- User Dropdown -->
        <x-dropdown align="{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" width="56">
            <x-slot name="trigger">
                <button class="flex items-center gap-4 group focus:outline-none">
                    <div class="text-end hidden sm:block">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">{{ Auth::user()->role === 'doctor' ? 'Clinic Admin' : 'Patient' }}</p>
                        <p class="text-sm font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black shadow-sm group-hover:scale-105 transition-all">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 border-b border-slate-50">
                    <p class="text-xs font-bold text-slate-400 mb-1">Logged in as</p>
                    <p class="text-sm font-black text-slate-800 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <x-dropdown-link :href="route('profile.edit')" class="font-bold text-slate-600 py-3">
                    {{ __('messages.settings') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 font-bold py-3">
                        {{ __('messages.logout') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
