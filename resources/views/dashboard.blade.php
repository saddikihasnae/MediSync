<x-app-layout>
    @section('title', 'Health Analytics Dashboard')

    <div x-data="{ 
        activeTab: '{{ request()->query('tab', 'overview') }}',
        showReportModal: false,
        selectedReport: null,
        showToast: false,
        toastMessage: '',
        showFilterDropdown: false,
        selectedAppointment: null,
        
        init() {
            @if(session('success'))
                this.toastMessage = '{{ session('success') }}';
                this.showToast = true;
                setTimeout(() => { this.showToast = false; }, 4000);
            @endif
        },
        
        openReport(report) {
            this.selectedReport = report;
            this.showReportModal = true;
        },
        
        triggerDownload(url) {
            this.toastMessage = 'Downloading report...';
            this.showToast = true;
            
            // Redirect to the download route
            if (url) {
                window.location.href = url;
            }
            
            setTimeout(() => { this.showToast = false; }, 3000);
        }
    }" class="min-h-screen relative">
        
        <!-- Toast Notification -->
        <div x-show="showToast" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-10"
             class="fixed bottom-10 end-10 z-[100] flex items-center gap-4 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl border border-slate-700"
             x-cloak>
            <div class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center animate-bounce">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </div>
            <p class="font-black text-sm tracking-tight" x-text="toastMessage"></p>
        </div>

        <!-- Pills Tabs with Alpine.js Logic -->
        <div class="mb-10 flex gap-2 p-1 bg-white rounded-2xl shadow-sm border border-slate-100 w-fit">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.overview') }}</button>
            <button @click="activeTab = 'reports'" :class="activeTab === 'reports' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.medical_reports') }}</button>
            <button @click="activeTab = 'patients'" :class="activeTab === 'patients' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.patients_directory') }}</button>
            <button @click="activeTab = 'diagnose'" :class="activeTab === 'diagnose' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-400 hover:bg-slate-50 hover:text-emerald-600'" class="px-6 py-2.5 rounded-xl text-sm font-black transition-all">{{ __('messages.diagnose_now') }}</button>
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
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('messages.' . $key) }}</p>
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter mb-4">{{ $stat['value'] }}</h3>
                        <div class="flex items-center gap-1">
                            <span class="text-xs font-black {{ str_contains($stat['change'], '+') ? 'text-emerald-500' : 'text-rose-500' }} bg-slate-50 px-2 py-1 rounded-lg">
                                {{ $stat['change'] }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">vs last month</span>
                        </div>
                    </div>
                    <div class="absolute bottom-0 end-0 w-32 h-16 opacity-10 group-hover:opacity-30 transition-opacity">
                        <svg viewBox="0 0 100 40" class="w-full h-full">
                            <path d="M0 35 Q 20 10, 40 30 T 80 5 T 100 25 V 40 H 0 Z" fill="currentColor" class="text-emerald-600" />
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
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ __('messages.financial_performance') }}</h3>
                            <p class="text-sm text-slate-400 font-medium">{{ __('messages.revenue_metrics') }}</p>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>
                <div class="lg:col-span-4 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <div class="mb-8 text-center">
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ __('messages.clinic_capacity') }}</h3>
                        <p class="text-sm text-slate-400 font-medium">{{ __('messages.resource_distribution') }}</p>
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
                    <h3 class="text-xl font-black text-slate-800 tracking-tight mb-16">{{ __('messages.today_schedule') }}</h3>
                    <div class="relative pb-24 px-4 overflow-x-auto no-scrollbar">
                        <div class="absolute start-0 end-0 top-6 h-1 bg-slate-100 rounded-full mx-10"></div>
                        <div class="flex justify-between min-w-[800px] relative">
                            @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $hour)
                            <div class="relative flex flex-col items-center group">
                                <div class="w-3 h-3 rounded-full {{ isset($todaySchedule[$hour]) ? 'bg-emerald-600 ring-4 ring-emerald-50 shadow-lg' : 'bg-slate-200' }} mb-4 transition-all z-10"></div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $hour }}</span>
                                @if(isset($todaySchedule[$hour]))
                                <div class="absolute top-16 left-1/2 -translate-x-1/2 w-48 group-hover:scale-105 transition-all">
                                    <div class="bg-emerald-600/90 backdrop-blur-md p-4 rounded-3xl text-white shadow-xl">
                                        <p class="text-[10px] font-black uppercase text-emerald-100 mb-1">{{ $todaySchedule[$hour][0]->patient->name }}</p>
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
                    <h3 class="text-xl font-black text-slate-800 tracking-tight mb-8">{{ __('messages.latest_visits') }}</h3>
                    <div class="space-y-6">
                        @foreach($latestVisits as $visit)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                                    <span class="text-emerald-600 font-black">{{ substr($visit->patient->name, 0, 1) }}</span>
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
        <div x-show="activeTab === 'reports'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-white relative">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ __('messages.medical_records_directory') }}</h3>
                        <p class="text-sm text-slate-400 font-bold">{{ __('messages.history_reports') }}</p>
                    </div>
                    
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <button @click="showFilterDropdown = !showFilterDropdown" class="p-3 bg-slate-50 text-slate-400 rounded-2xl hover:bg-emerald-50 hover:text-emerald-600 transition-all focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>
                        <div x-show="showFilterDropdown" @click.away="showFilterDropdown = false" class="absolute end-0 mt-4 w-60 bg-white rounded-[2rem] shadow-2xl border border-slate-100 z-50 p-3 overflow-hidden flex flex-col gap-1" x-cloak x-transition>
                            <p class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 mb-2 italic">{{ __('messages.select_category') }}</p>
                            
                            <a href="{{ route('dashboard', ['tab' => 'reports', 'type' => 'all']) }}" 
                               class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-black transition-all {{ request('type', 'all') == 'all' ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                                <span>{{ __('messages.all_reports') ?? 'All Reports' }}</span>
                                @if(request('type', 'all') == 'all') <div class="w-2 h-2 bg-emerald-500 rounded-full"></div> @endif
                            </a>

                            @foreach($reportTypes as $type)
                            <a href="{{ route('dashboard', ['tab' => 'reports', 'type' => $type]) }}" 
                               class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-black transition-all {{ request('type') == $type ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                                <span>{{ $type }}</span>
                                @if(request('type') == $type) <div class="w-2 h-2 bg-emerald-500 rounded-full"></div> @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.report_id') }}</th>
                                <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.patient') }}</th>
                                <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.status') }}</th>
                                <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.date') ?? 'Date' }}</th>
                                <th class="px-8 py-5 text-end text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($medicalReports as $report)
                            <tr class="hover:bg-slate-50 transition-all group">
                                <td class="px-8 py-6 text-sm font-black text-emerald-600 tracking-tight italic">#{{ $report->report_id }}</td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 font-black shadow-sm">
                                            {{ substr($report->patient->name, 0, 2) }}
                                        </div>
                                        <span class="text-sm font-black text-slate-700 tracking-tight">{{ $report->patient->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">{{ $report->type }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm font-bold text-slate-400">{{ $report->report_date->format('d M, Y') }}</td>
                                <td class="px-8 py-6 text-end space-x-2">
                                    <button @click="openReport({{ json_encode([
                                        'id' => $report->report_id,
                                        'patient' => $report->patient->name,
                                        'type' => $report->type,
                                        'date' => $report->report_date->format('d M, Y'),
                                        'content' => $report->result_summary,
                                        'download_url' => route('medical-reports.download', $report)
                                    ]) }})" class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                    <button @click="triggerDownload('{{ route('medical-reports.download', $report) }}')" class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-30">
                                        <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-xl font-black uppercase tracking-[0.2em] text-slate-400">{{ __('messages.no_records_found') }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="p-8 bg-slate-50/30 border-t border-slate-50">
                    {{ $medicalReports->appends(['tab' => 'reports', 'patients_page' => $patients->currentPage()])->links('vendor.pagination.tailwind_custom') }}
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: PATIENTS OVERVIEW -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'patients'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ __('messages.patients_directory') }}</h3>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-widest mt-1">{{ __('messages.manage_profiles') }}</p>
                </div>
                <button @click="$dispatch('open-modal', 'add-patient-modal')" class="bg-emerald-600 text-white px-8 py-4 rounded-[2rem] font-black text-sm shadow-xl shadow-emerald-100 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('messages.add_new_patient') }}
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @foreach($patients as $patient)
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 text-center group hover:shadow-2xl hover:border-emerald-100 transition-all duration-500 relative">
                    <div class="w-20 h-20 rounded-[2rem] bg-emerald-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500 relative">
                        <span class="text-3xl font-black text-emerald-600">{{ substr($patient->name, 0, 1) }}</span>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full"></div>
                    </div>
                    <h4 class="font-black text-xl text-slate-800 mb-1 tracking-tight">{{ $patient->name }}</h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 italic">{{ $patient->email }}</p>
                    
                    <div class="flex justify-center items-center gap-6 py-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ __('messages.age') }}</p>
                            <p class="text-sm font-black text-slate-700">{{ $patient->age ?? 'N/A' }}</p>
                        </div>
                        <div class="w-px h-6 bg-slate-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ __('messages.blood_group') }}</p>
                            <p class="text-sm font-black text-emerald-600">A+</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Patients Pagination -->
            <div class="flex justify-center py-6">
                {{ $patients->appends(['tab' => 'patients', 'reports_page' => $medicalReports->currentPage()])->links('vendor.pagination.tailwind_custom') }}
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 4: DIAGNOSE -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'diagnose'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Waiting List -->
                <div class="lg:col-span-4 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ __('messages.waiting_room') }}</h3>
                        <span class="bg-rose-100 text-rose-600 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest">{{ $pendingAppointments->count() }} Live</span>
                    </div>
                    <div class="space-y-4 custom-scrollbar max-h-[600px] overflow-y-auto pr-2">
                        @forelse($pendingAppointments as $app)
                        <div @click="selectedAppointment = { id: {{ $app->id }}, patient_name: '{{ $app->patient->name }}', service_name: '{{ $app->service->name }}' }" 
                             :class="selectedAppointment?.id === {{ $app->id }} ? 'bg-emerald-600 border-emerald-600' : 'bg-slate-50 border-slate-100 hover:bg-emerald-50 hover:border-emerald-100'"
                             class="p-5 rounded-3xl border flex justify-between items-center group cursor-pointer transition-all">
                            <div class="flex items-center gap-4">
                                <div :class="selectedAppointment?.id === {{ $app->id }} ? 'bg-white/20 text-white' : 'bg-white text-emerald-600'" 
                                     class="w-12 h-12 rounded-2xl flex items-center justify-center font-black shadow-sm group-hover:scale-110 transition-transform">
                                    {{ substr($app->patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <p :class="selectedAppointment?.id === {{ $app->id }} ? 'text-white' : 'text-slate-800'" 
                                       class="text-sm font-black transition-colors">{{ $app->patient->name }}</p>
                                    <p :class="selectedAppointment?.id === {{ $app->id }} ? 'text-emerald-100' : 'text-slate-400'" 
                                       class="text-[10px] font-black uppercase tracking-widest">{{ $app->service->name }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span :class="selectedAppointment?.id === {{ $app->id }} ? 'text-white' : 'text-emerald-600'" 
                                      class="text-[10px] font-black">{{ Carbon\Carbon::parse($app->appointment_date)->format('H:i') }}</span>
                                <svg :class="selectedAppointment?.id === {{ $app->id }} ? 'text-white' : 'text-slate-300'" 
                                     class="w-4 h-4 transition-colors mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <p class="text-xs font-black text-slate-300 uppercase italic">No pending visits</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Diagnosis Form -->
                <div class="lg:col-span-8 bg-white p-12 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden">
                    <!-- Empty State for Form -->
                    <div x-show="!selectedAppointment" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center text-center p-12">
                        <div class="w-24 h-24 bg-emerald-50 rounded-[2rem] flex items-center justify-center text-emerald-600 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="text-2xl font-black text-slate-800 mb-2">{{ __('messages.no_patient_selected') }}</h4>
                        <p class="text-slate-400 font-bold max-w-xs">{{ __('messages.select_patient_msg') }}</p>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ __('messages.active_consultation') }}</h3>
                        <p class="text-sm text-emerald-600 font-black uppercase tracking-widest mt-2 flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                            {{ __('messages.diagnosing') }} <span x-text="selectedAppointment?.patient_name" class="text-slate-800"></span>
                        </p>
                    </div>
                    
                    <form action="{{ route('diagnose.store') }}" method="POST" class="space-y-10">
                        @csrf
                        <input type="hidden" name="appointment_id" :value="selectedAppointment?.id">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.assigned_service') }}</label>
                                <div class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-6 font-black text-slate-400">
                                    <span x-text="selectedAppointment?.service_name"></span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.visit_category') }}</label>
                                <div class="relative">
                                    <select name="visit_category" required class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 px-6 font-black text-slate-700 transition-all outline-none appearance-none">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->name }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute end-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.symptoms_observations') }}</label>
                            <textarea name="symptoms" required rows="6" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-[2rem] p-8 font-black text-slate-700 placeholder-slate-300 transition-all outline-none" placeholder="{{ __('messages.enter_detailed_symptoms') ?? 'Enter detailed symptoms...' }}"></textarea>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ms-2">{{ __('messages.prescription_advice') }}</label>
                            <div class="relative">
                                <span class="absolute start-6 top-5 text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </span>
                                <input name="prescription" type="text" class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl py-4 ps-14 pe-6 font-black text-slate-700 placeholder-slate-300 transition-all outline-none" placeholder="Medication, Dosage, Period">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 text-white py-6 rounded-[2.5rem] font-black shadow-2xl shadow-emerald-100 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            {{ __('messages.save_close_consultation') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Medical Report Detail Modal -->
        <div x-show="showReportModal" 
             class="fixed inset-0 z-[110] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak>
            <div @click.away="showReportModal = false" 
                 class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="scale-90 opacity-0 translate-y-10"
                 x-transition:enter-end="scale-100 opacity-100 translate-y-0">
                
                <div class="p-10 border-b border-slate-50 bg-emerald-50/30 flex justify-between items-start">
                    <div>
                        <span class="px-4 py-1.5 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-4 inline-block shadow-lg shadow-emerald-200">Official Record</span>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter" x-text="'Report #' + selectedReport?.id"></h2>
                    </div>
                    <button @click="showReportModal = false" class="p-3 bg-white text-slate-400 hover:text-rose-600 rounded-2xl shadow-sm transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-12 space-y-10">
                    <div class="grid grid-cols-2 gap-12">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Patient Name</p>
                            <p class="text-xl font-black text-slate-800" x-text="selectedReport?.patient"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Exam Date</p>
                            <p class="text-xl font-black text-slate-800" x-text="selectedReport?.date"></p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Diagnostic Conclusion</p>
                        <p class="text-lg font-bold text-slate-600 italic leading-relaxed" x-text="selectedReport?.content || 'All vitals are normal and within established parameters. No immediate clinical intervention required.'"></p>
                    </div>

                    <div class="flex gap-4">
                        <button @click="triggerDownload(selectedReport.download_url); showReportModal = false" class="flex-1 bg-slate-900 text-white py-5 rounded-2xl font-black text-sm hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download PDF
                        </button>
                        <button class="px-8 py-5 border-2 border-slate-100 text-slate-400 font-black text-sm rounded-2xl hover:bg-slate-50 transition-all">Print</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modals -->
    <x-modal name="add-patient-modal" focusable>
        <div class="p-10 text-start">
            <h2 class="text-2xl font-black text-slate-800 mb-8">{{ __('messages.add_new_patient') }}</h2>
            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="patient">
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.full_name') }}</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.age') }}</label>
                        <input type="number" name="age" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.contact') }}</label>
                        <input type="text" name="phone" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ __('messages.email') }}</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold">
                </div>
                <input type="hidden" name="password" value="password">
                <input type="hidden" name="password_confirmation" value="password">
                <div class="flex justify-end gap-4 mt-10">
                    <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100">{{ __('messages.register_patient') }}</button>
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
                        backgroundColor: (context) => context.dataIndex === 5 ? '#10b981' : '#ecfdf5',
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
                        backgroundColor: ['#10b981', '#34d399', '#059669'],
                        borderWidth: 0,
                        cutout: '80%',
                        borderRadius: 20,
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        });
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b98120; border-radius: 10px; }
    </style>
</x-app-layout>
