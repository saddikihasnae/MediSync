@if($appointment)
    <!-- Delete Modal -->
    <x-modal name="delete-appointment-{{ $appointment->id }}" focusable>
        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="p-10 text-center">
            @csrf
            @method('DELETE')
            <div class="w-24 h-24 bg-rose-50 text-rose-500 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner border border-rose-100">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-3">{{ __('ui.common.confirm_delete') }}</h2>
            <p class="text-slate-500 font-bold mb-10 px-8 leading-relaxed">
                Êtes-vous sûr de vouloir supprimer le rendez-vous de <span class="text-rose-600 underline font-black">{{ $appointment->patient->name }}</span> ? Cette action est irréversible.
            </p>
            <div class="flex justify-center gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-slate-100 text-slate-500 font-black rounded-2xl hover:bg-slate-200 transition-all">
                    {{ __('ui.common.cancel') }}
                </button>
                <button type="submit" class="px-8 py-4 bg-rose-600 text-white font-black rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-700 transition-all active:scale-95">
                    {{ __('ui.common.delete') }}
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Modal -->
    <x-modal name="edit-appointment-{{ $appointment->id }}" focusable>
        <div class="p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ __('ui.common.edit') }}</h2>
            </div>
            <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.patient') }}</label>
                        <select name="patient_id" class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ $appointment->patient_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.service') }}</label>
                        <select name="service_id" class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" {{ $appointment->service_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.date') }}</label>
                        <input type="datetime-local" name="appointment_date" value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}" class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.status') }}</label>
                        <select name="status" class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-black text-slate-700 p-4">
                            @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $st)
                                <option value="{{ $st }}" {{ $appointment->status == $st ? 'selected' : '' }}>{{ __('ui.appointment.status.'.$st) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-10 flex justify-end gap-4">
                    <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-slate-100 text-slate-500 font-black rounded-2xl hover:bg-slate-200 transition-all">
                        {{ __('ui.common.cancel') }}
                    </button>
                    <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">
                        {{ __('ui.common.save') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
@else
    <!-- Add Modal -->
    <x-modal name="add-appointment-modal" focusable>
        <div class="p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="p-3 bg-emerald-600 text-white rounded-2xl shadow-lg shadow-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ __('ui.common.add') }}</h2>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.patient') }}</label>
                        <select name="patient_id" required class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                            <option value="">{{ __('Choisir un patient') }}</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.service') }}</label>
                        <select name="service_id" required class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                            <option value="">{{ __('Choisir un service') }}</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.doctor') }}</label>
                        <select name="doctor_id" required class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.date') }}</label>
                        <input type="datetime-local" name="appointment_date" required class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-bold text-slate-700 p-4">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('ui.appointment.status') }}</label>
                        <select name="status" class="w-full bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 font-black text-slate-700 p-4">
                            <option value="pending">{{ __('ui.appointment.status.pending') }}</option>
                            <option value="confirmed">{{ __('ui.appointment.status.confirmed') }}</option>
                        </select>
                    </div>
                </div>
                <div class="mt-10 flex justify-end gap-4">
                    <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-slate-100 text-slate-500 font-black rounded-2xl hover:bg-slate-200 transition-all">
                        {{ __('ui.common.cancel') }}
                    </button>
                    <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">
                        {{ __('ui.common.save') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
@endif
