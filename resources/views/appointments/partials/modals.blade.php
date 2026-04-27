<!-- Delete Confirmation Modal -->
<x-modal name="confirm-delete-{{ $appointment->id }}" focusable>
    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="p-8 text-start">
        @csrf
        @method('DELETE')
        <div class="mb-4 p-3 bg-rose-50 text-rose-600 rounded-xl w-fit">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h2 class="text-xl font-bold text-slate-800 mb-2">{{ __('messages.delete_confirm') }}</h2>
        <p class="text-slate-500 mb-8">هل أنت متأكد أنك تريد حذف موعد المريض <span class="font-bold text-slate-800">{{ $appointment->patient->name }}</span>؟ لا يمكن التراجع عن هذا الإجراء.</p>
        
        <div class="flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl">{{ __('messages.cancel') }}</x-secondary-button>
            <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-rose-100 transition-all duration-200">
                حذف الموعد
            </button>
        </div>
    </form>
</x-modal>

<!-- Edit Modal -->
<x-modal name="edit-modal-{{ $appointment->id }}" focusable>
    <div class="p-8 text-start">
        <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
            <span class="p-2 bg-blue-100 text-emerald-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
            </span>
            تعديل الموعد
        </h2>
        <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.patient') }}</label>
                    <select name="patient_id" required class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-emerald-500">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.services') }}</label>
                    <select name="service_id" required class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-emerald-500">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.doctor') }}</label>
                    <select name="doctor_id" required class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-emerald-500">
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">الحالة</label>
                    <select name="status" required class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-emerald-500">
                        <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.date_time') }}</label>
                    <input type="datetime-local" name="appointment_time" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d\TH:i') }}" required class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl">{{ __('messages.cancel') }}</x-secondary-button>
                <button type="submit" class="bg-emerald-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-blue-100 transition-all duration-200">
                    تحديث البيانات
                </button>
            </div>
        </form>
    </div>
</x-modal>
