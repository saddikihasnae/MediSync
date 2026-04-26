<aside class="w-72 bg-white shadow-sm min-h-screen border-e border-slate-100 z-40 flex flex-col">
    <div class="p-8">
        <a href="/" class="flex items-center gap-3">
            <div class="p-2.5 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-100">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <span class="text-2xl font-black text-slate-800 tracking-tight">MediSync</span>
        </a>
    </div>

    <nav class="mt-4 px-4 flex-1">
        <div class="space-y-2">
            @if(auth()->user()->role === 'doctor')
                <!-- Doctor Links -->
                <a href="{{ route('dashboard') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <svg class="ms-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-indigo-500' : 'text-slate-300 group-hover:text-indigo-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('messages.dashboard') }}
                </a>

                <a href="{{ route('appointments.index') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('appointments.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <svg class="ms-3 h-5 w-5 {{ request()->routeIs('appointments.*') ? 'text-indigo-500' : 'text-slate-300 group-hover:text-indigo-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('messages.all_appointments') }}
                </a>

                <a href="{{ route('services.index') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('services.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <svg class="ms-3 h-5 w-5 {{ request()->routeIs('services.*') ? 'text-indigo-500' : 'text-slate-300 group-hover:text-indigo-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ __('messages.services') }}
                </a>

                <a href="{{ route('patients.index') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <svg class="ms-3 h-5 w-5 {{ request()->routeIs('patients.*') ? 'text-indigo-500' : 'text-slate-300 group-hover:text-indigo-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{ __('messages.patients') }}
                </a>
            @elseif(auth()->user()->role === 'patient')
                <!-- Patient Links -->
                <a href="{{ route('dashboard') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <svg class="ms-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-indigo-500' : 'text-slate-300 group-hover:text-indigo-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('messages.my_appointments') ?? 'My Appointments' }}
                </a>
                
                <a href="{{ route('patient.book') }}" class="group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 {{ request()->routeIs('patient.book') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <svg class="ms-3 h-5 w-5 {{ request()->routeIs('patient.book') ? 'text-indigo-500' : 'text-slate-300 group-hover:text-indigo-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 11v1m5-10v1m0 10v1M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('messages.book_appointment') }}
                </a>
            @endif

            <hr class="border-slate-50 my-4">
            
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full group flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-200 text-slate-400 hover:bg-rose-50 hover:text-rose-600">
                    <svg class="ms-3 h-5 w-5 text-slate-300 group-hover:text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('messages.logout') }}
                </button>
            </form>
        </div>
    </nav>
</aside>
