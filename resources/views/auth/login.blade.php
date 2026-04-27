<x-guest-layout>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <!-- الجانب الأيسر: الصورة الطبية مع الطبقة الشفافة -->
        <div class="hidden lg:block relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=1200&q=80" alt="Medical Care" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-emerald-900/70 backdrop-blur-[2px] flex flex-col justify-center items-center text-white p-12">
                <div class="mb-8 p-6 bg-white/10 backdrop-blur-xl rounded-[3rem] border border-white/20 shadow-2xl">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h1 class="text-5xl font-black mb-4 tracking-tighter italic">MediSync Clinic</h1>
                <p class="text-xl text-emerald-50/80 font-medium tracking-wide text-center">We care for your health every day.</p>
            </div>
        </div>

        <!-- الجانب الأيمن: منطقة النموذج الممركزة -->
        <div class="flex flex-col justify-center bg-white dark:bg-slate-950 p-8 md:p-16 relative transition-colors duration-300">
            
            <!-- مبدل اللغة -->
            <div class="absolute top-8 right-8 flex items-center bg-slate-50 dark:bg-slate-900 p-1 rounded-2xl border border-slate-100 dark:border-slate-800">
                <a href="{{ route('lang.switch', 'ar') }}" class="px-5 py-2 text-[10px] font-black rounded-xl transition-all {{ app()->getLocale() == 'ar' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:text-emerald-600' }}">AR</a>
                <a href="{{ route('lang.switch', 'fr') }}" class="px-5 py-2 text-[10px] font-black rounded-xl transition-all {{ app()->getLocale() == 'fr' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:text-emerald-600' }}">FR</a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-5 py-2 text-[10px] font-black rounded-xl transition-all {{ app()->getLocale() == 'en' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:text-emerald-600' }}">EN</a>
            </div>

            <!-- حاوية النموذج (لمنع التمدد البشع) -->
            <div class="max-w-md w-full mx-auto">
                <div class="mb-12">
                    <h2 class="text-4xl font-black text-slate-800 dark:text-white mb-3 tracking-tight">{{ __('messages.login') }}</h2>
                    <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.welcome') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">{{ __('messages.email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-transparent focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 rounded-2xl py-4 px-5 transition-all outline-none font-bold text-slate-700 dark:text-slate-200 shadow-sm shadow-slate-100 dark:shadow-none">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">{{ __('messages.password') }}</label>
                        <input id="password" type="password" name="password" required class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-transparent focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 rounded-2xl py-4 px-5 transition-all outline-none font-bold text-slate-700 dark:text-slate-200 shadow-sm shadow-slate-100 dark:shadow-none">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- إصلاح مكان "نسيت كلمة المرور" وتذكرني في نفس السطر -->
                    <div class="flex items-center justify-between px-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-200 dark:border-slate-800 dark:bg-slate-900 text-emerald-600 shadow-sm focus:ring-emerald-500">
                            <span class="ms-3 text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors">{{ __('messages.remember_me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-black text-emerald-600 hover:text-emerald-700 uppercase tracking-widest transition-colors">{{ __('messages.forgot_password') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none transition-all transform active:scale-[0.98] uppercase tracking-[0.2em] text-xs">
                        {{ __('messages.login') }}
                    </button>

                    <div class="text-center pt-8 border-t border-slate-50 dark:border-slate-900">
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                            {{ __('messages.no_account') }} 
                            <a href="{{ route('register') }}" class="text-emerald-600 font-black ml-2 hover:underline">{{ __('messages.register') }}</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
