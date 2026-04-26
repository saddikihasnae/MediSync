<aside class="w-72 bg-white shadow-sm min-h-screen border-e border-slate-100 z-40 flex flex-col">
    <div class="p-8">
        <a href="/" class="flex items-center gap-3">
            <div class="p-2.5 bg-emerald-600 rounded-2xl shadow-lg shadow-emerald-100">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <span class="text-2xl font-black text-slate-800 tracking-tight">MediSync</span>
        </a>
    </div>

    <nav class="mt-4 px-4 flex-1">
        <div class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600' }}">
                <svg class="ms-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-emerald-500' : 'text-slate-300 group-hover:text-emerald-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('messages.dashboard') }}
            </a>

            <!-- Appointments -->
            <a href="{{ route('appointments.index') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('appointments.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600' }}">
                <svg class="ms-3 h-5 w-5 {{ request()->routeIs('appointments.*') ? 'text-emerald-500' : 'text-slate-300 group-hover:text-emerald-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ __('messages.appointments') }}
            </a>

            <!-- Services -->
            <a href="{{ route('services.index') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('services.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600' }}">
                <svg class="ms-3 h-5 w-5 {{ request()->routeIs('services.*') ? 'text-emerald-500' : 'text-slate-300 group-hover:text-emerald-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{ __('messages.services') }}
            </a>

            <!-- Patients (Placeholder Link) -->
            <a href="#" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 text-slate-400 hover:bg-slate-50 hover:text-emerald-600">
                <svg class="ms-3 h-5 w-5 text-slate-300 group-hover:text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                {{ __('messages.patients') }}
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-slate-50">
        <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl text-slate-400 hover:bg-slate-50 hover:text-emerald-600 transition-all">
            <svg class="ms-3 h-5 w-5 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ __('messages.settings') }}
        </a>
    </div>
</aside>
