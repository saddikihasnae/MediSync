@section('title', 'Settings & Preferences')

<x-app-layout>
    <div x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }" :class="{ 'dark': darkMode }" class="min-h-screen transition-colors duration-300">
        
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- SECTION 1: PREFERENCES -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 p-10 overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 dark:bg-indigo-900/20 rounded-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-100 dark:shadow-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ __('Preferences') }}</h2>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">Personalize your experience</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Language Choice -->
                        <div class="space-y-4">
                            <p class="text-sm font-black text-slate-700 dark:text-slate-300">{{ __('Language') }}</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach(['ar' => 'العربية', 'fr' => 'Français', 'en' => 'English'] as $code => $label)
                                <a href="{{ route('lang.switch', $code) }}" 
                                   class="px-6 py-3 rounded-2xl border-2 transition-all font-bold text-sm {{ app()->getLocale() == $code ? 'border-emerald-600 bg-emerald-50 text-emerald-600 dark:bg-indigo-900/30' : 'border-slate-100 text-slate-400 dark:border-slate-700 dark:text-slate-500 hover:border-emerald-200' }}">
                                    {{ $label }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Appearance Choice -->
                        <div class="space-y-4">
                            <p class="text-sm font-black text-slate-700 dark:text-slate-300">{{ __('Appearance') }}</p>
                            <button @click="toggleDarkMode()" 
                                    class="w-full flex items-center justify-between px-6 py-4 bg-slate-50 dark:bg-slate-900/50 rounded-[2rem] group border border-transparent hover:border-emerald-200 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all" 
                                         :class="darkMode ? 'bg-indigo-900 text-emerald-400' : 'bg-amber-100 text-amber-600'">
                                        <template x-if="!darkMode">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path></svg>
                                        </template>
                                        <template x-if="darkMode">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                                        </template>
                                    </div>
                                    <span class="font-bold text-slate-800 dark:text-white" x-text="darkMode ? 'Dark Mode' : 'Light Mode'"></span>
                                </div>
                                <div class="w-12 h-6 rounded-full p-1 transition-colors duration-300" 
                                     :class="darkMode ? 'bg-emerald-600' : 'bg-slate-200'">
                                    <div class="bg-white w-4 h-4 rounded-full shadow-sm transform transition-transform duration-300" 
                                         :class="darkMode ? 'translate-x-6' : 'translate-x-0'"></div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: PROFILE INFORMATION -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 p-10">
                <div class="mb-10">
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ __('Profile Information') }}</h2>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">{{ __("Update your account's profile information and email address.") }}</p>
                </div>
                
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- SECTION 3: SECURITY -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 p-10">
                <div class="mb-10">
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ __('Update Password') }}</h2>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                </div>
                
                @include('profile.partials.update-password-form')
            </div>

            <!-- SECTION 4: DANGER ZONE -->
            <div class="bg-rose-50 dark:bg-rose-900/10 rounded-[2.5rem] border border-rose-100 dark:border-rose-900/30 p-10">
                <div class="mb-10">
                    <h2 class="text-2xl font-black text-rose-600 dark:text-rose-500">{{ __('Delete Account') }}</h2>
                    <p class="text-xs font-black text-rose-400 uppercase tracking-widest mt-1">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                </div>
                
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
