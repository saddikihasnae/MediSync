<x-app-layout>
    <div x-data="{ 
        showAddModal: false, 
        showDetailsModal: false, 
        showEditModal: false, 
        showDeleteModal: false,
        selectedPatient: null,
        searchQuery: '',
        patients: @js($patients->items()),

        async searchPatients() {
            const response = await axios.get('{{ route('patients.search') }}?search=' + this.searchQuery);
            this.patients = response.data;
        },

        openDetails(patient) {
            this.selectedPatient = { ...patient };
            this.showDetailsModal = true;
        },

        openEdit(patient = null) {
            if (patient) {
                this.selectedPatient = { ...patient };
            }
            this.showDetailsModal = false;
            this.showEditModal = true;
        },

        openDelete(patient = null) {
            if (patient) {
                this.selectedPatient = { ...patient };
            }
            this.showDetailsModal = false;
            this.showDeleteModal = true;
        }
    }" class="min-h-screen bg-[#f8fafc] dark:bg-slate-950 px-4 py-6 sm:px-6 lg:px-8 transition-colors duration-300">
        
        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('messages.total_patients') }}</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('messages.new_this_month') }}</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $stats['new_this_month'] }}</h3>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 flex items-center gap-6">
                <div class="w-16 h-16 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('messages.active_cases') }}</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $stats['active_cases'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Patients Table Card -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="relative w-full md:w-96">
                    <input type="text" x-model="searchQuery" @input.debounce.300ms="searchPatients()" placeholder="{{ __('messages.search_patient') }}" 
                           class="w-full ps-12 pe-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-900/20 transition-all font-bold text-slate-700 dark:text-slate-200">
                    <svg class="w-5 h-5 absolute start-4 top-3.5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button @click="showAddModal = true" class="w-full md:w-auto px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none hover:bg-emerald-700 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('messages.add_new_patient') }}
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-8 py-5 text-start text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.patient_id') }}</th>
                            <th class="px-8 py-5 text-start text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.name') }}</th>
                            <th class="px-8 py-5 text-start text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.contact') }}</th>
                            <th class="px-8 py-5 text-start text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.status') }}</th>
                            <th class="px-8 py-5 text-end text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        <template x-for="p in patients" :key="p.id">
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-8 py-6 text-sm font-bold text-slate-400 dark:text-slate-500">P-<span x-text="p.id.toString().padStart(3, '0')"></span></td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4 cursor-pointer" @click="openDetails(p)">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 font-black shadow-sm group-hover:scale-110 transition-transform">
                                            <span x-text="p.name.charAt(0)"></span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800 dark:text-white" x-text="p.name"></p>
                                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase" x-text="p.email"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span class="text-sm font-bold text-slate-600 dark:text-slate-400" x-text="p.phone || 'N/A'"></span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span :class="{
                                        'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 border-emerald-100 dark:border-emerald-800': p.status === 'Stable',
                                        'bg-amber-50 dark:bg-amber-900/20 text-amber-600 border-amber-100 dark:border-amber-800': p.status === 'Under Treatment',
                                        'bg-blue-50 dark:bg-blue-900/20 text-emerald-600 border-blue-100 dark:border-blue-800': p.status === 'Recovered'
                                    }" class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border" 
                                    x-text="p.status === 'Stable' ? '{{ __('messages.stable') }}' : (p.status === 'Under Treatment' ? '{{ __('messages.under_treatment') }}' : '{{ __('messages.recovered') }}')"></span>
                                </td>
                                <td class="px-8 py-6 text-end">
                                    <div class="flex justify-end gap-2">
                                        <button @click="openDetails(p)" class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:bg-emerald-600 hover:text-white rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button @click="openEdit(p)" class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
                                        </button>
                                        <button @click="openDelete(p)" class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:bg-rose-600 hover:text-white rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-8 py-6 bg-slate-50/50 dark:bg-slate-800/50 border-t border-slate-50 dark:border-slate-800">
                {{ $patients->links() }}
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: VIEW DETAILS -->
        <!-- ========================================== -->
        <div x-show="showDetailsModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showDetailsModal = false" class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] shadow-2xl p-10 text-center border border-white/10">
                <template x-if="selectedPatient">
                    <div>
                        <div class="w-24 h-24 rounded-[2.5rem] bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 text-4xl font-black mx-auto mb-6 shadow-md border-4 border-white dark:border-slate-800">
                            <span x-text="selectedPatient.name.charAt(0)"></span>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-1" x-text="selectedPatient.name"></h3>
                        <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-8" x-text="selectedPatient.phone"></p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-10">
                            <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-2xl">
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('messages.blood_group') }}</p>
                                <p class="text-sm font-black text-slate-800 dark:text-slate-200" x-text="selectedPatient.blood_group || 'N/A'"></p>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-2xl">
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('messages.last_visit') }}</p>
                                <p class="text-sm font-black text-slate-800 dark:text-slate-200" x-text="selectedPatient.last_visit ? new Date(selectedPatient.last_visit).toLocaleDateString() : '{{ __('messages.never') ?? 'Never' }}'"></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button @click="openEdit()" class="w-full py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
                                {{ __('messages.edit_patient') }}
                            </button>
                            <button @click="openDelete()" class="w-full py-4 bg-rose-50 dark:bg-rose-900/10 text-rose-600 font-black rounded-2xl hover:bg-rose-600 hover:text-white transition-all">
                                {{ __('messages.delete_patient') }}
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: ADD / EDIT PATIENT -->
        <!-- ========================================== -->
        <div x-show="showAddModal || showEditModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showAddModal = false; showEditModal = false" class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-[2.5rem] shadow-2xl p-10 transform transition-all border border-white/10">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-8" x-text="showEditModal ? 'Edit Patient' : 'Add New Patient'"></h2>
                <form :action="showEditModal ? '{{ url('patients') }}/' + selectedPatient.id : '{{ route('patients.store') }}'" method="POST" class="space-y-6">
                    @csrf
                    <template x-if="showEditModal"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.full_name') }}</label>
                        <input type="text" name="name" x-model="selectedPatient.name" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-900/20">
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.email') }}</label>
                            <input type="email" name="email" x-model="selectedPatient.email" :required="!showEditModal" :disabled="showEditModal" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200 disabled:opacity-50">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.contact') }}</label>
                            <input type="text" name="phone" x-model="selectedPatient.phone" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.age') }}</label>
                            <input type="number" name="age" x-model="selectedPatient.age" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.gender') }}</label>
                            <select name="gender" x-model="selectedPatient.gender" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200">
                                <option value="Male">{{ __('messages.male') }}</option>
                                <option value="Female">{{ __('messages.female') }}</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.blood_group') }}</label>
                            <select name="blood_group" x-model="selectedPatient.blood_group" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200">
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('messages.status') }}</label>
                        <select name="status" x-model="selectedPatient.status" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-slate-200">
                            <option value="Stable">{{ __('messages.stable') }}</option>
                            <option value="Under Treatment">{{ __('messages.under_treatment') }}</option>
                            <option value="Recovered">{{ __('messages.recovered') }}</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-4 mt-10">
                        <button type="button" @click="showAddModal = false; showEditModal = false" class="px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-black rounded-2xl">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none" x-text="showEditModal ? '{{ __('messages.save_changes') }}' : '{{ __('messages.register_patient') }}'"></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: DELETE CONFIRMATION -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak x-transition class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md">
            <div class="bg-white dark:bg-slate-900 w-full max-sm rounded-[2.5rem] shadow-2xl p-10 text-center border border-white/10">
                <div class="w-16 h-16 bg-rose-100 dark:bg-rose-900/20 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-2">{{ __('messages.delete_patient') }}</h3>
                <p class="text-sm text-slate-400 dark:text-slate-500 font-bold mb-10 leading-relaxed">{{ __('messages.confirm_delete_patient') }}</p>
                <form :action="'{{ url('patients') }}/' + selectedPatient?.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white font-black rounded-2xl shadow-xl shadow-rose-100 dark:shadow-none hover:bg-rose-700 transition-all uppercase tracking-widest text-xs">{{ __('messages.delete') }}</button>
                        <button type="button" @click="showDeleteModal = false" class="w-full py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-black rounded-2xl transition-all uppercase tracking-widest text-xs">{{ __('messages.cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
