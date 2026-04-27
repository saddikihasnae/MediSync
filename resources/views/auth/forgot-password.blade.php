<x-guest-layout>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <!-- الجانب الأيسر: الصورة الطبية الموحدة -->
        <div class="hidden lg:block relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=1200&q=80" alt="Medical Care" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-emerald-900/70 backdrop-blur-[2px] flex flex-col justify-center items-center text-white p-12 text-center">
                <div class="mb-8 p-6 bg-white/10 backdrop-blur-xl rounded-[3rem] border border-white/20 shadow-2xl">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h1 class="text-5xl font-black mb-4 tracking-tighter italic">Reset Password</h1>
                <p class="text-xl text-emerald-50/80 font-medium tracking-wide">Don't worry, we'll help you get back to your dashboard safely.</p>
            </div>
        </div>

        <!-- الجانب الأيمن: نموذج استعادة كلمة المرور الممركز -->
        <div class="flex flex-col justify-center bg-white p-8 md:p-16 relative">
            
            <div class="absolute top-8 right-8 flex items-center bg-slate-50 p-1 rounded-2xl border border-slate-100">
                <a href="{{ route('lang.switch', 'ar') }}" class="px-5 py-2 text-[10px] font-black rounded-xl transition-all {{ app()->getLocale() == 'ar' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:text-emerald-600' }}">AR</a>
                <a href="{{ route('lang.switch', 'fr') }}" class="px-5 py-2 text-[10px] font-black rounded-xl transition-all {{ app()->getLocale() == 'fr' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:text-emerald-600' }}">FR</a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-5 py-2 text-[10px] font-black rounded-xl transition-all {{ app()->getLocale() == 'en' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:text-emerald-600' }}">EN</a>
            </div>

            <div class="max-w-md w-full mx-auto">
                <div class="mb-8 text-center lg:text-start">
                    <h2 class="text-4xl font-black text-slate-800 mb-4 tracking-tight">{{ __('messages.forgot_password') }}</h2>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('messages.email') }}</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-5 transition-all outline-none font-bold text-slate-700 shadow-sm shadow-slate-100">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 transition-all transform active:scale-[0.98] uppercase tracking-[0.2em] text-xs">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>

                    <div class="text-center pt-8 border-t border-slate-50">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                            <a href="{{ route('login') }}" class="text-emerald-600 font-black hover:underline tracking-normal flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                {{ __('Back to Login') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
