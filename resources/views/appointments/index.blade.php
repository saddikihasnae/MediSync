<x-app-layout>
    <x-slot name="header">
        {{ __('messages.appointments') }}
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h3 class="text-lg font-semibold text-gray-800">قائمة المواعيد</h3>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <!-- Search Input -->
            <div class="relative flex-1 md:w-64">
                <input type="text" id="searchInput" placeholder="بحث باسم المريض أو الخدمة..." 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2">
            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'quick-add-modal')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm transition whitespace-nowrap">
                إضافة سريعة +
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="appointmentsTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">المريض</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">الخدمة</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">الطبيب</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ والوقت</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="appointmentsBody">
                    @forelse($appointments as $appointment)
                        <tr id="appointment-row-{{ $appointment->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $appointment->patient->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $appointment->service->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $appointment->doctor->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" dir="ltr">
                                {{ $appointment->appointment_time }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $appointment->status == 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $appointment->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $appointment->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                <div class="flex justify-end space-x-2 space-x-reverse">
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">تعديل</a>
                                    
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $appointment->id }}')" 
                                            class="text-red-600 hover:text-red-900">حذف</button>

                                    <!-- Delete Confirmation Modal -->
                                    <x-modal name="confirm-delete-{{ $appointment->id }}" focusable>
                                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="p-6">
                                            @csrf
                                            @method('DELETE')
                                            <h2 class="text-lg font-medium text-gray-900">هل أنت متأكد من حذف هذا الموعد؟</h2>
                                            <p class="mt-1 text-sm text-gray-600">هذا الإجراء لا يمكن التراجع عنه.</p>
                                            <div class="mt-6 flex justify-end gap-3">
                                                <x-secondary-button x-on:click="$dispatch('close')">إلغاء</x-secondary-button>
                                                <x-danger-button type="submit">تأكيد الحذف</x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                لا توجد مواعيد مسجلة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4" id="paginationLinks">
            {{ $appointments->links() }}
        </div>
    </div>

    <!-- Quick Add Modal -->
    <x-modal name="quick-add-modal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">إضافة موعد سريع</h2>
            <form id="quickAddForm">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">المريض</label>
                        <select name="patient_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">اختر مريضاً</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">الخدمة</label>
                        <select name="service_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">اختر خدمة</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">الطبيب</label>
                        <select name="doctor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">اختر طبيباً</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">التاريخ والوقت</label>
                        <input type="datetime-local" name="appointment_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">إلغاء</x-secondary-button>
                    <x-primary-button type="button" id="submitQuickAdd">حفظ الموعد</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const appointmentsBody = document.getElementById('appointmentsBody');
            const quickAddForm = document.getElementById('quickAddForm');
            const submitQuickAdd = document.getElementById('submitQuickAdd');

            // Search Logic
            searchInput.addEventListener('input', function() {
                const search = this.value;
                axios.get('{{ route("appointments.index") }}', {
                    params: { search: search },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    const appointments = response.data;
                    let html = '';
                    if (appointments.length > 0) {
                        appointments.forEach(app => {
                            html += `
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${app.patient.name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${app.service.name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${app.doctor.name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" dir="ltr">${app.appointment_time}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">${app.status}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <a href="/appointments/${app.id}/edit" class="text-indigo-600 hover:text-indigo-900">تعديل</a>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        html = '<tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">لا توجد نتائج</td></tr>';
                    }
                    appointmentsBody.innerHTML = html;
                    document.getElementById('paginationLinks').style.display = search ? 'none' : 'block';
                });
            });

            // Quick Add Logic
            submitQuickAdd.addEventListener('click', function() {
                const formData = new FormData(quickAddForm);
                const data = Object.fromEntries(formData.entries());

                axios.post('{{ route("appointments.store") }}', data, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                    alert('خطأ في إدخال البيانات. يرجى التحقق من الحقول.');
                });
            });
        });
    </script>
</x-app-layout>
