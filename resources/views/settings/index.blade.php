<x-app-layout>
    @section('title', 'Settings')

    <div x-data="{ activeTab: '{{ session('active_tab') ?? 'profile' }}' }" class="min-h-screen">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ __('messages.settings') }}</h1>
            <p class="text-slate-400 dark:text-slate-500 font-bold mt-2 uppercase tracking-widest text-xs">{{ __('messages.manage_clinic') }}</p>
        </div>

        <!-- Pills Tabs (Matching Dashboard Style) -->
        <div class="mb-10 flex gap-2 p-1 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 w-fit">
            <button @click="activeTab = 'profile'" 
                    :class="activeTab === 'profile' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600'" 
                    class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.my_profile') }}</button>
            @if(auth()->user()->role !== 'patient')
            <button @click="activeTab = 'clinic'" 
                    :class="activeTab === 'clinic' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600'" 
                    class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.clinic_details') }}</button>
            @endif
            <button @click="activeTab = 'security'" 
                    :class="activeTab === 'security' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600'" 
                    class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.security') }}</button>
            <button @click="activeTab = 'preferences'" 
                    :class="activeTab === 'preferences' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600'" 
                    class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.preferences') ?? 'Preferences' }}</button>
        </div>

        <!-- Tab Content -->
        <div class="max-w-4xl">
            <!-- My Profile -->
            <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 p-10">
                    <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="flex items-center gap-8 mb-10 pb-10 border-b border-slate-50">
                            <div class="relative group">
                                <div class="w-24 h-24 bg-emerald-100 rounded-[2.5rem] flex items-center justify-center text-3xl font-black text-emerald-600 shadow-inner overflow-hidden">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    @endif
                                </div>
                                <label for="avatar_input" class="absolute inset-0 bg-black/40 text-white flex items-center justify-center rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </label>
                                <input type="file" id="avatar_input" name="avatar" class="hidden" @change="$el.form.submit()">
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800 dark:text-white">{{ __('messages.profile_picture') }}</h3>
                                <p class="text-sm text-slate-400 font-bold mb-2">PNG, JPG or GIF. Max 2MB.</p>
                                <button type="button" @click="document.getElementById('avatar_input').click()" class="px-6 py-2 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-black text-xs rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 transition-all">{{ __('messages.upload_new') }}</button>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.full_name') }}</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                                    @error('name') <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.email') }}</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 rounded-2xl py-4 px-6 font-black text-slate-700 dark:text-slate-200 transition-all outline-none">
                                    @error('email') <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            @if(auth()->user()->role !== 'patient')
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.medical_specialty') }}</label>
                                <input type="text" name="specialty" value="{{ old('specialty', auth()->user()->specialty ?? __('messages.general_practitioner')) }}" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 rounded-2xl py-4 px-6 font-black text-slate-700 dark:text-slate-200 transition-all outline-none">
                                @error('specialty') <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </div>
                            @endif
                            <div class="pt-4">
                                <button type="submit" class="bg-emerald-600 text-white px-10 py-4 rounded-2xl font-black text-sm shadow-xl shadow-emerald-100 hover:scale-[1.02] active:scale-95 transition-all">{{ __('messages.save_changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(auth()->user()->role !== 'patient')
            <!-- Clinic Details -->
            <div x-show="activeTab === 'clinic'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 p-10">
                    <form action="{{ route('settings.clinic.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.clinic_name') }}</label>
                                    <input type="text" name="clinic_name" value="{{ $clinicSettings['clinic_name'] ?? '' }}" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.contact_number') }}</label>
                                    <input type="text" name="clinic_phone" value="{{ $clinicSettings['clinic_phone'] ?? '' }}" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.clinic_address') }}</label>
                                <input type="text" name="clinic_address" value="{{ $clinicSettings['clinic_address'] ?? '' }}" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.working_hours') }}</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <span class="absolute start-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 dark:text-slate-600">{{ __('messages.from') }}</span>
                                        <input type="time" name="working_hours_from" value="{{ $clinicSettings['working_hours_from'] ?? '09:00' }}" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 rounded-2xl py-4 ps-14 pe-6 font-black text-slate-700 dark:text-slate-200 transition-all outline-none">
                                    </div>
                                    <div class="relative">
                                        <span class="absolute start-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 dark:text-slate-600">{{ __('messages.to') }}</span>
                                        <input type="time" name="working_hours_to" value="{{ $clinicSettings['working_hours_to'] ?? '18:00' }}" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 rounded-2xl py-4 ps-12 pe-6 font-black text-slate-700 dark:text-slate-200 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="bg-emerald-600 text-white px-10 py-4 rounded-2xl font-black text-sm shadow-xl shadow-emerald-100 hover:scale-[1.02] active:scale-95 transition-all">{{ __('messages.update_clinic_info') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Security -->
            <div x-show="activeTab === 'security'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                    <div class="mb-10">
                        <h3 class="text-xl font-black text-slate-800 dark:text-white">{{ __('messages.security') }}</h3>
                        <p class="text-sm text-slate-400 dark:text-slate-500 font-bold">{{ __('messages.update_password') }}</p>
                    </div>
                    <form action="{{ route('settings.password.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.current_password') }}</label>
                                <input type="password" name="current_password" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                                @error('current_password') <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.new_password') }}</label>
                                    <input type="password" name="password" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                                    @error('password') <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.confirm_new_password') }}</label>
                                    <input type="password" name="password_confirmation" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none">
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-sm shadow-xl shadow-slate-200 hover:scale-[1.02] active:scale-95 transition-all">{{ __('messages.update_password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preferences -->
            <div x-show="activeTab === 'preferences'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 p-10">
                    <div class="space-y-12">
                        <!-- Language -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 dark:text-white">{{ __('messages.interface_language') }}</h3>
                                <p class="text-sm text-slate-400 dark:text-slate-500 font-bold">{{ __('messages.select_category') }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between p-4 rounded-2xl border-2 {{ app()->getLocale() == 'en' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' : 'border-slate-50 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-400' }} font-black text-sm transition-all">
                                    English (US)
                                    @if(app()->getLocale() == 'en')
                                        <div class="w-4 h-4 bg-emerald-500 rounded-full flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center justify-between p-4 rounded-2xl border-2 {{ app()->getLocale() == 'fr' ? 'border-emerald-500 bg-emerald-50 text-emerald-600' : 'border-slate-50 bg-slate-50 text-slate-400' }} font-black text-sm transition-all">
                                    Français
                                    @if(app()->getLocale() == 'fr')
                                        <div class="w-4 h-4 bg-emerald-500 rounded-full flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center justify-between p-4 rounded-2xl border-2 {{ app()->getLocale() == 'ar' ? 'border-emerald-500 bg-emerald-50 text-emerald-600' : 'border-slate-50 bg-slate-50 text-slate-400' }} font-black text-sm transition-all">
                                    العربية
                                    @if(app()->getLocale() == 'ar')
                                        <div class="w-4 h-4 bg-emerald-500 rounded-full flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @endif
                                </a>
                            </div>
                        </div>

                        <!-- Theme (Global Dark Mode) -->
                        <div class="flex items-center justify-between py-8 border-t border-slate-50 dark:border-slate-800">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 dark:text-white">{{ __('messages.dark_mode') }}</h3>
                                <p class="text-sm text-slate-400 dark:text-slate-500 font-bold">{{ __('messages.resource_distribution') }}</p>
                            </div>
                            <div class="relative inline-block w-16 h-8 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle" 
                                       class="toggle-checkbox absolute block w-8 h-8 rounded-full bg-white dark:bg-slate-200 border-4 border-slate-200 dark:border-slate-700 appearance-none cursor-pointer outline-none transition-all duration-300 checked:translate-x-8 checked:border-emerald-500"
                                       :checked="$store.theme.dark"
                                       @click="$store.theme.toggle()"/>
                                <label for="toggle" class="toggle-label block overflow-hidden h-8 rounded-full bg-slate-100 dark:bg-slate-800 cursor-pointer transition-all duration-300" :class="$store.theme.dark ? 'bg-emerald-500' : 'bg-slate-100 dark:bg-slate-800'"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>
