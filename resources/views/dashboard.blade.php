<x-app-layout>
    <div x-data="{ activeTab: 'overview' }" class="min-h-screen bg-[#f8fafc] px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Header & Top Navigation -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 gap-2">
                        <span class="hover:text-indigo-600 cursor-pointer transition-colors">Pages</span>
                        <span>/</span>
                        <span class="text-slate-800">Dashboard</span>
                    </nav>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Health Analytics Overview</h1>
                </div>
                
                <div class="flex items-center gap-6 bg-white p-2 rounded-2xl shadow-sm border border-slate-50 w-full md:w-auto">
                    <div class="relative flex-1 md:w-64">
                        <input type="text" placeholder="Search data, reports..." class="w-full bg-slate-50 border-none rounded-xl text-sm py-2 pl-10 focus:ring-2 focus:ring-indigo-100 transition-all">
                        <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div class="flex items-center gap-3 pr-2">
                        <button class="p-2 text-slate-400 hover:bg-slate-50 rounded-xl relative transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-indigo-500 rounded-full border-2 border-white"></span>
                        </button>
                        <!-- Avatar removed as requested -->
                    </div>
                </div>
            </div>

            <!-- Pills Tabs with Alpine.js Logic -->
            <div class="flex gap-2 p-1 bg-white rounded-2xl shadow-sm border border-slate-100 w-fit">
                <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">Overview</button>
                <button @click="activeTab = 'reports'" :class="activeTab === 'reports' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">Medical Reports</button>
                <button @click="activeTab = 'patients'" :class="activeTab === 'patients' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">Patients Overview</button>
                <button @click="activeTab = 'diagnose'" :class="activeTab === 'diagnose' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">Diagnose</button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: OVERVIEW -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @foreach($stats as $key => $stat)
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="relative z-10">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ str_replace('_', ' ', $key) }}</p>
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter mb-4">{{ $stat['value'] }}</h3>
                        <div class="flex items-center gap-1">
                            <span class="text-xs font-black {{ str_contains($stat['change'], '+') ? 'text-emerald-500' : 'text-rose-500' }} bg-slate-50 px-2 py-1 rounded-lg">
                                {{ $stat['change'] }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">vs last month</span>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 w-32 h-16 opacity-10 group-hover:opacity-30 transition-opacity">
                        <svg viewBox="0 0 100 40" class="w-full h-full">
                            <path d="M0 35 Q 20 10, 40 30 T 80 5 T 100 25 V 40 H 0 Z" fill="currentColor" class="text-{{ $stat['color'] }}-600" />
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Charts Area -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
                <div class="lg:col-span-8 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Overview Statistics</h3>
                            <p class="text-sm text-slate-400 font-medium">Monthly revenue and patient flow</p>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>
                <div class="lg:col-span-4 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <div class="mb-8 text-center">
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Avg Diagnose</h3>
                        <p class="text-sm text-slate-400 font-medium">Condition distribution</p>
                    </div>
                    <div class="h-64 relative flex items-center justify-center">
                        <canvas id="diagnoseChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-3xl font-black text-slate-800">84%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline & Visits -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 relative">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight mb-16">Today's Schedule</h3>
                    <div class="relative pb-24 px-4 overflow-x-auto no-scrollbar">
                        <div class="absolute left-0 right-0 top-6 h-1 bg-slate-100 rounded-full mx-10"></div>
                        <div class="flex justify-between min-w-[800px] relative">
                            @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $hour)
                            <div class="relative flex flex-col items-center group">
                                <div class="w-3 h-3 rounded-full {{ isset($todaySchedule[$hour]) ? 'bg-indigo-600 ring-4 ring-indigo-50 shadow-lg' : 'bg-slate-200' }} mb-4 transition-all z-10"></div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $hour }}</span>
                                @if(isset($todaySchedule[$hour]))
                                <div class="absolute top-16 left-1/2 -translate-x-1/2 w-48 group-hover:scale-105 transition-all">
                                    <div class="bg-indigo-600/90 backdrop-blur-md p-4 rounded-3xl text-white shadow-xl">
                                        <p class="text-[10px] font-black uppercase text-indigo-100 mb-1">{{ $todaySchedule[$hour][0]->patient->name }}</p>
                                        <p class="text-xs font-bold">{{ $todaySchedule[$hour][0]->service->name }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight mb-8">Latest Visits</h3>
                    <div class="space-y-6">
                        @foreach($latestVisits as $visit)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                                    <span class="text-indigo-600 font-black">{{ substr($visit->patient->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $visit->patient->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $visit->service->name }}</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-black text-slate-400">{{ \Carbon\Carbon::parse($visit->appointment_date)->format('H:i') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: MEDICAL REPORTS -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'reports'" x-cloak x-transition>
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-black text-slate-800">Medical Reports</h3>
                    <div class="relative w-64">
                        <input type="text" placeholder="Search by patient..." class="w-full bg-slate-50 border-none rounded-xl text-sm py-2 pl-10 focus:ring-2 focus:ring-indigo-100">
                        <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">Report ID</th>
                                <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">Patient</th>
                                <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">Type</th>
                                <th class="px-8 py-5 text-start text-xs font-black text-slate-400 uppercase tracking-widest">Date</th>
                                <th class="px-8 py-5 text-end text-xs font-black text-slate-400 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($medicalReports as $report)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6 text-sm font-bold text-slate-400">#{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-8 py-6 text-sm font-black text-slate-800">{{ $report->patient->name }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">{{ $report->type }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm font-bold text-slate-500">{{ $report->created_at->format('M d, Y') }}</td>
                                <td class="px-8 py-6 text-end">
                                    <button class="text-indigo-600 font-black text-xs hover:underline uppercase tracking-widest">View PDF</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: PATIENTS OVERVIEW -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'patients'" x-cloak x-transition>
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-black text-slate-800">Patients Directory</h3>
                <button @click="$dispatch('open-modal', 'add-patient-modal')" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 hover:scale-105 transition-all">Add New Patient</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($patients as $patient)
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 text-center group hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-[1.5rem] bg-indigo-50 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="text-2xl font-black text-indigo-600">{{ substr($patient->name, 0, 1) }}</span>
                    </div>
                    <h4 class="font-black text-slate-800 mb-1">{{ $patient->name }}</h4>
                    <p class="text-xs font-bold text-slate-400 mb-4">{{ $patient->age }} Years Old</p>
                    <div class="flex justify-center gap-4 text-[10px] font-black uppercase tracking-widest">
                        <div class="text-slate-400">Stable</div>
                        <div class="w-px h-3 bg-slate-100"></div>
                        <div class="text-emerald-500">Active</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 4: DIAGNOSE -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'diagnose'" x-cloak x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Waiting List -->
                <div class="lg:col-span-4 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-xl font-black text-slate-800 mb-8 tracking-tight">Waiting Room</h3>
                    <div class="space-y-4">
                        @foreach($pendingAppointments as $app)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-center group cursor-pointer hover:bg-indigo-50 hover:border-indigo-100 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center font-black text-indigo-600 shadow-sm">{{ substr($app->patient->name, 0, 1) }}</div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $app->patient->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $app->service->name }}</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Diagnosis Form -->
                <div class="lg:col-span-8 bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-2xl font-black text-slate-800 mb-10 tracking-tight">Patient Diagnosis</h3>
                    <form action="#" class="space-y-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Select Patient</label>
                                <select class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                                    <option>Select from waiting list...</option>
                                    @foreach($pendingAppointments as $app)
                                        <option value="{{ $app->id }}">{{ $app->patient->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Category</label>
                                <select class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700">
                                    <option>Chronic Condition</option>
                                    <option>Acute Illness</option>
                                    <option>Routine Checkup</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Medical Notes (Symptoms & Observation)</label>
                            <textarea rows="4" class="w-full bg-slate-50 border-none rounded-3xl p-6 font-bold text-slate-700 placeholder-slate-300" placeholder="Type symptoms here..."></textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Prescription</label>
                            <input type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 placeholder-slate-300" placeholder="Medication, Dosage, Frequency">
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 text-white py-5 rounded-[2rem] font-black shadow-xl shadow-emerald-100 hover:scale-[1.02] active:scale-[0.98] transition-all">Save Diagnosis & Complete Visit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <x-modal name="add-patient-modal" focusable>
        <div class="p-10">
            <h2 class="text-2xl font-black text-slate-800 mb-8">Add New Patient</h2>
            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="patient">
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Full Name</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Age</label>
                        <input type="number" name="age" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Phone Number</label>
                        <input type="text" name="phone" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                </div>
                <input type="hidden" name="password" value="password">
                <input type="hidden" name="password_confirmation" value="password">
                <div class="flex justify-end gap-4 mt-10">
                    <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl">Cancel</button>
                    <button type="submit" class="px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100">Register Patient</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Overview Bar Chart
            const ctxOverview = document.getElementById('overviewChart').getContext('2d');
            new Chart(ctxOverview, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                    datasets: [{
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000],
                        backgroundColor: (context) => context.dataIndex === 5 ? '#4f46e5' : '#e0e7ff',
                        borderRadius: 12,
                        barThickness: 32,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { display: false }, x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10, weight: 'bold' } } } }
                }
            });

            // Diagnose Doughnut Chart
            const ctxDiagnose = document.getElementById('diagnoseChart').getContext('2d');
            new Chart(ctxDiagnose, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [30, 40, 20],
                        backgroundColor: ['#4f46e5', '#60a5fa', '#34d399'],
                        borderWidth: 0,
                        cutout: '80%',
                        borderRadius: 20,
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        });
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
