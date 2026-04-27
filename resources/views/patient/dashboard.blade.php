<x-app-layout>
    <div x-data="{ 
        showBookingModal: false, 
        showCancelModal: false,
        selectedAppToCancel: null,
        appointmentDates: @js($appointmentDates)
    }" class="min-h-screen bg-[#f8fafc] dark:bg-slate-950 px-4 py-8 sm:px-6 lg:px-12 transition-colors duration-300">
        
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 to-violet-600 rounded-[2.5rem] p-10 mb-12 shadow-2xl shadow-emerald-100">
            <!-- Decorative Circles -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="text-center md:text-start">
                    <p class="text-emerald-100 font-black uppercase tracking-[0.3em] text-[10px] mb-4">{{ __('messages.welcome_banner_subtitle') }}</p>
                    <h1 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tight leading-tight">
                        {!! __('messages.welcome_banner_title') !!}
                    </h1>
                    <p class="text-lg text-emerald-100/80 font-medium">{!! __('messages.welcome_back_patient', ['name' => auth()->user()->name]) !!}</p>
                </div>
                
                <button @click="showBookingModal = true" class="px-10 py-5 bg-white dark:bg-emerald-600 text-emerald-600 dark:text-white font-black rounded-3xl shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-3 active:scale-95">
                    <div class="w-8 h-8 bg-emerald-50 dark:bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    {{ __('messages.book_appointment_btn') }}
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content (Left) -->
            <div class="lg:col-span-2 space-y-12">
                
                <!-- Next Appointment Section -->
                <div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-emerald-600 rounded-full"></span>
                        {{ __('messages.next_appointment') }}
                    </h2>

                    @if($upcomingAppointment)
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8 group hover:shadow-xl transition-all duration-500">
                        <div class="flex items-center gap-6">
                            <div class="w-20 h-20 bg-emerald-50 dark:bg-slate-800 rounded-[2rem] flex flex-col items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-inner">
                                <span class="text-[10px] font-black uppercase">{{ Carbon\Carbon::parse($upcomingAppointment->appointment_date)->format('M') }}</span>
                                <span class="text-2xl font-black">{{ Carbon\Carbon::parse($upcomingAppointment->appointment_date)->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-1">{{ $upcomingAppointment->service->name }}</h3>
                                <div class="flex items-center gap-4 text-sm font-bold text-slate-400">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ Carbon\Carbon::parse($upcomingAppointment->appointment_date)->format('H:i') }}
                                    </span>
                                    <span class="w-1 h-1 bg-slate-200 dark:bg-slate-700 rounded-full"></span>
                                    <span class="flex items-center gap-1.5 text-emerald-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ ucfirst($upcomingAppointment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <button @click="selectedAppToCancel = @js($upcomingAppointment); showCancelModal = true" class="px-6 py-3 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 font-black rounded-2xl hover:bg-rose-600 hover:text-white transition-all duration-300 text-xs uppercase tracking-widest">
                            {{ __('messages.cancel_appointment') }}
                        </button>
                    </div>
                    @else
                    <div class="bg-slate-50 dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-12 text-center">
                        <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 dark:text-slate-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold">{{ __('messages.no_upcoming_appointments') }}</p>
                        <button @click="showBookingModal = true" class="mt-4 text-emerald-600 font-black hover:underline transition-all">{{ __('messages.book_first_session_now') }}</button>
                    </div>
                    @endif
                </div>

                <!-- Past Visits Section -->
                <div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-slate-300 dark:bg-slate-700 rounded-full"></span>
                        {{ __('messages.past_visits') }}
                    </h2>

                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                        <table class="w-full">
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                @forelse($pastAppointments as $past)
                                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-all duration-300">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-500 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-800 dark:text-white">{{ $past->service->name }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ Carbon\Carbon::parse($past->appointment_date)->format('D, d M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-end">
                                        <span class="px-4 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800 rounded-full text-[10px] font-black uppercase tracking-widest">
                                            {{ $past->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-8 py-10 text-center text-slate-400 font-bold">{{ __('messages.no_visit_history') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Widgets (Right) -->
            <div class="space-y-12">
                
                <!-- Doctor Card -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800 text-center relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-50 dark:bg-emerald-900/20 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-24 h-24 rounded-[2.5rem] bg-emerald-50 dark:bg-slate-800 border-4 border-white dark:border-slate-900 shadow-lg flex items-center justify-center mx-auto mb-6">
                            <span class="text-4xl font-black text-emerald-600">A</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 dark:text-white mb-1">{{ $doctor->name ?? 'Dr. Ahmed Ali' }}</h3>
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-8">{{ __('messages.general_practitioner') }}</p>
                        
                        <div class="space-y-3">
                            <a href="tel:+212600000000" class="w-full py-4 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-black rounded-2xl flex items-center justify-center gap-3 hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ __('messages.contact_clinic') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">{{ __('messages.schedule') }}</h3>
                        <span class="text-[10px] font-black text-emerald-600">{{ now()->format('F Y') }}</span>
                    </div>
                    
                    <div class="grid grid-cols-7 gap-2 text-center text-[10px] font-black text-slate-400 mb-4">
                        <span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span><span>S</span>
                    </div>
                    
                    <div class="grid grid-cols-7 gap-2 text-center">
                        @php
                            $startOfMonth = now()->startOfMonth();
                            $endOfMonth = now()->endOfMonth();
                            $padding = $startOfMonth->dayOfWeekIso - 1;
                        @endphp
                        
                        @for($i = 0; $i < $padding; $i++)
                            <div class="h-8"></div>
                        @endfor
                        
                        @for($day = 1; $day <= $endOfMonth->day; $day++)
                            @php $dateStr = now()->format('Y-m-') . sprintf('%02d', $day); @endphp
                            <div class="h-8 flex items-center justify-center text-xs font-bold rounded-lg transition-all {{ in_array($dateStr, $appointmentDates) ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100 scale-110' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                                {{ $day }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: BOOK APPOINTMENT -->
        <!-- ========================================== -->
        <div x-show="showBookingModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div @click.away="showBookingModal = false" class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-[2.5rem] shadow-2xl p-10 transform transition-all overflow-y-auto max-h-[90vh]">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-8">{{ __('messages.new_appointment') }}</h2>
                <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ auth()->id() }}">
                    
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.service') }}</label>
                        <select name="service_id" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-emerald-100 transition-all">
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ number_format($s->price) }} MAD)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.date_time') }}</label>
                        <input type="datetime-local" name="appointment_date" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-emerald-100 transition-all">
                    </div>

                    <div class="p-6 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800 mb-4">
                        <p class="text-xs font-bold text-indigo-700 dark:text-emerald-400 leading-relaxed">
                            <span class="font-black uppercase tracking-widest block mb-1">{{ __('messages.confirmation_policy_title') }}</span>
                            {{ __('messages.confirmation_policy_text') }}
                        </p>
                    </div>

                    <div class="flex justify-end gap-4 mt-10">
                        <button type="button" @click="showBookingModal = false" class="px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-black rounded-2xl transition-colors">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100">{{ __('messages.confirm_booking') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: CANCEL APPOINTMENT -->
        <!-- ========================================== -->
        <div x-show="showCancelModal" x-cloak x-transition class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-[2.5rem] shadow-2xl p-10 text-center border border-slate-100 dark:border-slate-800">
                <div class="w-16 h-16 bg-rose-100 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-2">{{ __('messages.cancel_session_confirm') }}</h3>
                <p class="text-sm text-slate-400 dark:text-slate-500 font-bold mb-10 leading-relaxed">{{ __('messages.cancel_session_text', ['service' => '']) }}<span class="text-slate-800 dark:text-slate-200" x-text="selectedAppToCancel?.service?.name"></span>?</p>
                <form :action="'{{ url('appointments') }}/' + selectedAppToCancel?.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white font-black rounded-2xl shadow-xl shadow-rose-100 dark:shadow-none hover:bg-rose-700 transition-all uppercase tracking-widest text-xs">{{ __('messages.yes_cancel_session') }}</button>
                        <button type="button" @click="showCancelModal = false" class="w-full py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-black rounded-2xl transition-all uppercase tracking-widest text-xs">{{ __('messages.keep_it') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
