<x-app-layout>
    <div x-data="{ 
        showAddModal: false, 
        showEditModal: false, 
        showDetailsModal: false, 
        showDeleteConfirm: false,
        selectedApp: null,
        searchQuery: '',
        appointments: @js($appointments),

        async searchAppointments() {
            const response = await axios.get('{{ route('appointments.search') }}?search=' + this.searchQuery);
            this.appointments = response.data;
        },

        openEdit() {
            this.showDetailsModal = false;
            this.showEditModal = true;
        }
    }" class="min-h-screen bg-[#f8fafc]">
        
        <!-- Top Bar -->
        <div class="px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
            <div class="relative w-full md:w-96">
                <input type="text" x-model="searchQuery" @input.debounce.300ms="searchAppointments()" placeholder="{{ __('messages.search_patient') }}" 
                       class="w-full pl-12 pr-4 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-bold">
                <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <button @click="showAddModal = true" class="w-full md:w-auto px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('messages.new_appointment') }}
            </button>
        </div>

        @if(session('success'))
            <div class="mx-8 mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold rounded-2xl animate-fade-in flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Calendar Grid -->
        <div class="mx-8 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/30">
                <div class="p-4 border-r border-slate-100"></div>
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    $hours = range(8, 17);
                @endphp
                @foreach($days as $day)
                <div class="p-6 text-center border-r border-slate-100 last:border-r-0">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.'.strtolower($day)) }}</p>
                    <p class="text-lg font-black text-slate-800">{{ $startOfWeek->copy()->addDays($loop->index)->format('d') }}</p>
                </div>
                @endforeach
            </div>

            <div class="relative overflow-y-auto max-h-[700px]">
                @foreach($hours as $hour)
                <div class="grid grid-cols-7 border-b border-slate-50 last:border-b-0 group">
                    <div class="p-4 text-center border-r border-slate-100 bg-slate-50/20 flex items-center justify-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ sprintf('%02d:00', $hour) }}</span>
                    </div>

                    @foreach($days as $day)
                    <div class="min-h-[120px] border-r border-slate-50 last:border-r-0 p-2 relative group-hover:bg-slate-50/10 transition-colors">
                        <template x-if="appointments['{{ $day }}']">
                            <div class="space-y-2">
                                <template x-for="app in appointments['{{ $day }}']" :key="app.id">
                                    <template x-if="new Date(app.appointment_date).getHours() == {{ $hour }}">
                                        <div @click="selectedApp = app; showDetailsModal = true" 
                                             :class="{
                                                 'bg-emerald-600 text-white shadow-emerald-100': app.service.name.includes('Surgery') || app.service.name.includes('Cardiology'),
                                                 'bg-emerald-50 text-emerald-700 border border-emerald-100': app.service.name.includes('Consultation') || app.service.name.includes('Pediatrics'),
                                                 'bg-amber-50 text-amber-700 border border-amber-100': app.service.name.includes('Dental') || app.service.name.includes('Radiology')
                                             }"
                                             class="p-3 rounded-2xl shadow-sm cursor-pointer hover:scale-[1.03] transition-all duration-300 border-2 border-transparent hover:border-white">
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="w-1.5 h-1.5 rounded-full bg-current opacity-50"></div>
                                                <p class="text-[10px] font-black uppercase tracking-wider truncate" x-text="app.patient.name"></p>
                                            </div>
                                            <p class="text-[9px] font-bold opacity-80 truncate" x-text="app.service.name"></p>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </template>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: ADD APPOINTMENT -->
        <!-- ========================================== -->
        <div x-show="showAddModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div @click.away="showAddModal = false" class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl p-10">
                <h2 class="text-2xl font-black text-slate-800 mb-8">{{ __('messages.new_appointment') }}</h2>
                <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.patient') }}</label>
                        <select name="patient_id" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-emerald-100">
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.service') }}</label>
                        <select name="service_id" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-emerald-100">
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.date_time') }}</label>
                        <input type="datetime-local" name="appointment_date" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div class="flex justify-end gap-4 mt-10">
                        <button type="button" @click="showAddModal = false" class="px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: EDIT APPOINTMENT -->
        <!-- ========================================== -->
        <div x-show="showEditModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div @click.away="showEditModal = false" class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl p-10">
                <h2 class="text-2xl font-black text-slate-800 mb-8">{{ __('messages.edit') }}</h2>
                <template x-if="selectedApp">
                    <form :action="'{{ url('appointments') }}/' + selectedApp.id" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.patient') }}</label>
                            <select name="patient_id" x-model="selectedApp.patient_id" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                                @foreach($patients as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.service') }}</label>
                            <select name="service_id" x-model="selectedApp.service_id" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.date_time') }}</label>
                            <input type="datetime-local" name="appointment_date" :value="new Date(selectedApp.appointment_date).toISOString().slice(0, 16)" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.status') }}</label>
                            <select name="status" x-model="selectedApp.status" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                                <option value="pending">{{ __('messages.pending') ?? 'Pending' }}</option>
                                <option value="confirmed">{{ __('messages.confirmed') ?? 'Confirmed' }}</option>
                                <option value="completed">{{ __('messages.completed') ?? 'Completed' }}</option>
                                <option value="cancelled">{{ __('messages.cancelled') ?? 'Cancelled' }}</option>
                            </select>
                        </div>
                        <div class="flex justify-end gap-4 mt-10">
                            <button type="button" @click="showEditModal = false" class="px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl">{{ __('messages.cancel') }}</button>
                            <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100">{{ __('messages.save') }}</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: APPOINTMENT DETAILS -->
        <!-- ========================================== -->
        <div x-show="showDetailsModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div @click.away="showDetailsModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-10 text-center">
                <template x-if="selectedApp">
                    <div>
                        <div class="w-20 h-20 rounded-[2rem] bg-emerald-50 border-4 border-white shadow-md flex items-center justify-center mx-auto mb-6">
                            <span class="text-3xl font-black text-emerald-600" x-text="selectedApp.patient.name.charAt(0)"></span>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 mb-1" x-text="selectedApp.patient.name"></h3>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8" x-text="selectedApp.service.name"></p>
                        <div class="flex justify-center gap-4">
                            <button @click="openEdit()" class="p-4 bg-slate-100 text-emerald-600 rounded-2xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
                            </button>
                            <button @click="showDeleteConfirm = true; showDetailsModal = false" class="p-4 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: DELETE CONFIRMATION -->
        <!-- ========================================== -->
        <div x-show="showDeleteConfirm" x-cloak x-transition class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl p-10 text-center">
                <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">{{ __('messages.confirm_delete_msg') }}</h3>
                <p class="text-sm text-slate-400 font-bold mb-10 leading-relaxed">This action is permanent and cannot be undone.</p>
                <form :action="'{{ url('appointments') }}/' + selectedApp?.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white font-black rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-700 transition-all uppercase tracking-widest text-xs">Yes, Delete Appointment</button>
                        <button type="button" @click="showDeleteConfirm = false" class="w-full py-4 bg-slate-100 text-slate-400 font-black rounded-2xl transition-all uppercase tracking-widest text-xs">No, Keep it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</x-app-layout>
