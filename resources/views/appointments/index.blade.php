<x-app-layout>
    <x-slot name="header">
        {{ __('ui.appointments') }}
    </x-slot>

    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="w-full md:w-96 relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-500 text-slate-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" id="searchInput" placeholder="{{ __('ui.appointment.search_placeholder') }}" 
                   class="w-full pl-12 pr-6 py-4 bg-white border border-slate-100 rounded-2xl focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all duration-300 shadow-sm font-medium">
        </div>

        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-appointment-modal')" 
                class="w-full md:w-auto px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 hover:shadow-emerald-200 transition-all active:scale-95 flex items-center justify-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('ui.common.add') }}
        </button>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 font-bold flex items-center gap-4 animate-bounce">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full" id="appointmentsTable">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('ui.appointment.patient') }}</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('ui.appointment.service') }}</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('ui.appointment.date') }}</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('ui.appointment.status') }}</th>
                        <th class="px-8 py-5 text-end text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('ui.appointment.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50" id="appointmentsBody">
                    @forelse($appointments as $app)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-black border border-slate-200 group-hover:bg-emerald-50 group-hover:text-emerald-600 group-hover:border-emerald-100 transition-all">
                                        {{ substr($app->patient->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-black text-slate-800">{{ $app->patient->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-600">{{ $app->service->name }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500" dir="ltr">{{ \Carbon\Carbon::parse($app->appointment_date)->format('Y-m-d H:i') }}</td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'confirmed' => 'bg-emerald-100 text-emerald-700',
                                        'completed' => 'bg-blue-100 text-blue-700',
                                        'cancelled' => 'bg-rose-100 text-rose-700',
                                    ];
                                @endphp
                                <span class="px-5 py-2 text-xs font-black rounded-full {{ $statusClasses[$app->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ __('ui.appointment.status.' . $app->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-end">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-appointment-{{ $app->id }}')" class="p-2.5 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.123 3.897a2.25 2.25 0 113.182 3.182L12 14.25l-3.5 1 1-3.5 7.623-7.623z"></path></svg>
                                    </button>
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'delete-appointment-{{ $app->id }}')" class="p-2.5 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>

                                <!-- Modals -->
                                @include('appointments.partials.pro_modals', ['appointment' => $app])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center gap-4 text-slate-300">
                                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-xl font-black">{{ __('ui.common.no_results') ?? 'Aucun rendez-vous trouvé' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 bg-slate-50/20" id="paginationLinks">
            {{ $appointments->links() }}
        </div>
    </div>

    <!-- Global Add Modal -->
    @include('appointments.partials.pro_modals', ['appointment' => null])

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const appointmentsBody = document.getElementById('appointmentsBody');
            const paginationLinks = document.getElementById('paginationLinks');

            let timeout = null;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
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
                                const statusClasses = {
                                    'pending': 'bg-amber-100 text-amber-700',
                                    'confirmed': 'bg-emerald-100 text-emerald-700',
                                    'completed': 'bg-blue-100 text-blue-700',
                                    'cancelled': 'bg-rose-100 text-rose-700'
                                };
                                const classList = statusClasses[app.status] || 'bg-slate-100 text-slate-700';
                                
                                html += `
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-black border border-slate-200">
                                                    ${app.patient.name.charAt(0)}
                                                </div>
                                                <span class="text-sm font-black text-slate-800">${app.patient.name}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-sm font-bold text-slate-600">${app.service.name}</td>
                                        <td class="px-8 py-6 text-sm font-bold text-slate-500" dir="ltr">${app.appointment_date}</td>
                                        <td class="px-8 py-6">
                                            <span class="px-5 py-2 text-xs font-black rounded-full ${classList}">
                                                ${app.status}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-end">
                                            <p class="text-xs text-slate-400">Search Mode</p>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = '<tr><td colspan="5" class="px-8 py-16 text-center text-slate-300">Aucun résultat</td></tr>';
                        }
                        appointmentsBody.innerHTML = html;
                        paginationLinks.style.display = search ? 'none' : 'block';
                    });
                }, 300);
            });
        });
    </script>
</x-app-layout>
