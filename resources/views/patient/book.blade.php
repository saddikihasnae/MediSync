<x-app-layout>
    <div x-data="{ 
        step: 1, 
        selectedService: null,
        selectedServiceName: '',
        date: '',
        notes: ''
    }" class="min-h-screen bg-[#f8fafc] px-4 py-8 sm:px-6 lg:px-12">
        
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black text-slate-800 mb-4 tracking-tight">{{ __('messages.book_your_appointment') }}</h1>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">{{ __('messages.booking_steps_subtitle') }}</p>
            </div>

            <!-- Steps Progress -->
            <div class="flex items-center justify-center gap-4 mb-12">
                <template x-for="i in [1, 2, 3]">
                    <div class="flex items-center">
                        <div :class="step >= i ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-400'" 
                             class="w-10 h-10 rounded-full flex items-center justify-center font-black transition-all duration-500 shadow-lg" x-text="i"></div>
                        <div x-show="i < 3" :class="step > i ? 'bg-emerald-600' : 'bg-slate-200'" class="w-12 h-1 mx-2 rounded-full transition-all duration-500"></div>
                    </div>
                </template>
            </div>

            <form action="{{ route('patient.book.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" :value="selectedService">

                <!-- STEP 1: SELECT SERVICE -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                    <h2 class="text-xl font-black text-slate-800 mb-8 text-center">{{ __('messages.step_1_select_service') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($services as $service)
                        <div @click="selectedService = {{ $service->id }}; selectedServiceName = '{{ $service->name }}'; step = 2" 
                             :class="selectedService == {{ $service->id }} ? 'border-emerald-600 bg-emerald-50 ring-4 ring-emerald-100' : 'border-slate-100 bg-white hover:border-indigo-300'"
                             class="p-8 rounded-[2.5rem] border-2 cursor-pointer transition-all duration-300 group relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform"></div>
                            
                            <div class="relative z-10">
                                <h3 class="text-lg font-black text-slate-800 mb-2">{{ $service->name }}</h3>
                                <p class="text-sm text-slate-400 font-medium mb-6 line-clamp-2">{{ $service->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">{{ $service->duration_minutes }} Min</span>
                                    <span class="text-xl font-black text-slate-800 tracking-tighter">{{ number_format($service->price) }} MAD</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 2: DATE & TIME -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 max-w-xl mx-auto">
                        <h2 class="text-xl font-black text-slate-800 mb-8 text-center">{{ __('messages.step_2_choose_date_time') }}</h2>
                        <div class="space-y-6">
                            <div class="p-6 bg-emerald-50 rounded-3xl border border-emerald-100 mb-6">
                                <p class="text-xs font-bold text-indigo-700">{{ __('messages.selected_service_label') }} <span class="font-black text-indigo-900" x-text="selectedServiceName"></span></p>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.appointment_date_time_label') }}</label>
                                <input type="datetime-local" name="appointment_date" x-model="date" required 
                                       class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100 transition-all">
                            </div>
                            <div class="flex gap-4 pt-6">
                                <button type="button" @click="step = 1" class="flex-1 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl">{{ __('messages.back') }}</button>
                                <button type="button" @click="if(date) step = 3" class="flex-1 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100">{{ __('messages.next_step') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: CONFIRMATION -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 max-w-xl mx-auto text-center">
                        <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800 mb-2">{{ __('messages.final_step_review_confirm') }}</h2>
                        <p class="text-sm font-bold text-slate-400 mb-10">{{ __('messages.review_details_subtitle') }}</p>

                        <div class="space-y-4 mb-10">
                            <div class="flex justify-between p-4 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">{{ __('messages.service') }}</span>
                                <span class="text-sm font-black text-slate-800" x-text="selectedServiceName"></span>
                            </div>
                            <div class="flex justify-between p-4 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">{{ __('messages.date_time') }}</span>
                                <span class="text-sm font-black text-slate-800" x-text="date.replace('T', ' ')"></span>
                            </div>
                            <div class="space-y-2 text-start">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.medical_notes_optional') }}</label>
                                <textarea name="notes" x-model="notes" rows="3" placeholder="{{ __('messages.symptoms_placeholder') }}" 
                                          class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100 transition-all"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <button type="submit" class="w-full py-5 bg-emerald-600 text-white font-black rounded-3xl shadow-2xl shadow-emerald-100 hover:scale-[1.02] transition-all">{{ __('messages.confirm_book_appointment') }}</button>
                            <button type="button" @click="step = 2" class="w-full py-4 bg-slate-100 text-slate-400 font-black rounded-2xl">{{ __('messages.go_back') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
