<x-app-layout>
    <div x-data="{ 
        showServiceModal: false, 
        showDeleteConfirm: false,
        isEdit: false,
        selectedService: { id: null, name: '', description: '', price: '', duration_minutes: '' },

        openAdd() {
            this.isEdit = false;
            this.selectedService = { id: null, name: '', description: '', price: '', duration_minutes: '' };
            this.showServiceModal = true;
        },

        openEdit(service) {
            this.isEdit = true;
            this.selectedService = { ...service };
            this.showServiceModal = true;
        },

        openDelete(service) {
            this.selectedService = { ...service };
            this.showDeleteConfirm = true;
        }
    }" class="min-h-screen bg-[#f8fafc] px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ __('messages.services') }}</h1>
                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest mt-1">Management Console</p>
            </div>
            
            <button @click="openAdd()" class="w-full md:w-auto px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('messages.add_service') }}
            </button>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold rounded-2xl animate-fade-in flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative group hover:shadow-xl transition-all duration-500 overflow-hidden">
                <!-- Decorative Icon Background -->
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-100 flex items-center justify-center text-white shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800 leading-tight">{{ $service->name }}</h3>
                                <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mt-0.5">{{ $service->duration_minutes }} Min</p>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <button @click="openEdit(@js($service))" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
                            </button>
                            <button @click="openDelete(@js($service))" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm text-slate-400 font-medium leading-relaxed line-clamp-3 mb-6">{{ $service->description ?? 'No description provided for this medical service.' }}</p>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-50 pt-6 mt-auto">
                        <div class="bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-[10px] font-black text-indigo-700 uppercase tracking-tighter">Active</span>
                        </div>
                        <div class="text-end">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-0.5">{{ __('messages.price') }}</p>
                            <p class="text-2xl font-black text-slate-800 tracking-tighter">{{ number_format($service->price, 0) }} <span class="text-xs font-bold text-slate-400">MAD</span></p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-slate-400 font-bold">No services found. Start by adding one!</p>
            </div>
            @endforelse
        </div>

        <!-- ========================================== -->
        <!-- MODAL: ADD / EDIT SERVICE -->
        <!-- ========================================== -->
        <div x-show="showServiceModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div @click.away="showServiceModal = false" class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl p-10 transform transition-all">
                <h2 class="text-2xl font-black text-slate-800 mb-8" x-text="isEdit ? '{{ __('messages.edit') }}' : '{{ __('messages.add_service') }}'"></h2>
                <form :action="isEdit ? '{{ url('services') }}/' + selectedService.id : '{{ route('services.store') }}'" method="POST" class="space-y-6">
                    @csrf
                    <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.service_name') }}</label>
                        <input type="text" name="name" x-model="selectedService.name" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-indigo-100">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.description') }}</label>
                        <textarea name="description" x-model="selectedService.description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-indigo-100"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.price') }} (MAD)</label>
                            <input type="number" name="price" x-model="selectedService.price" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.duration') }}</label>
                            <input type="number" name="duration_minutes" x-model="selectedService.duration_minutes" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-10">
                        <button type="button" @click="showServiceModal = false" class="px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl transition-all">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all" x-text="isEdit ? '{{ __('messages.save') }}' : '{{ __('messages.save') }}'"></button>
                    </div>
                </form>
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
                <p class="text-sm text-slate-400 font-bold mb-10 leading-relaxed" x-text="'Delete service: ' + selectedService.name"></p>
                
                <form :action="'{{ url('services') }}/' + selectedService.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white font-black rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-700 transition-all uppercase tracking-widest text-xs">Yes, Delete Service</button>
                        <button type="button" @click="showDeleteConfirm = false" class="w-full py-4 bg-slate-100 text-slate-400 font-black rounded-2xl transition-all uppercase tracking-widest text-xs">No, Keep it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
    </style>
</x-app-layout>
