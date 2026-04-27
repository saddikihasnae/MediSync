<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\MedicalReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'doctor') {
            return $this->doctorDashboard($request);
        }

        return $this->patientDashboard();
    }

    protected function doctorDashboard(Request $request)
    {
        $today = Carbon::today();
        
        $stats = [
            'total_patients' => ['value' => number_format(User::where('role', 'patient')->count()), 'change' => '+12.5%', 'color' => 'indigo'],
            'today_appointments' => ['value' => number_format(Appointment::whereDate('appointment_date', $today)->count()), 'change' => '+4.3%', 'color' => 'blue'],
            'active_services' => ['value' => number_format(Service::count()), 'change' => '+0.0%', 'color' => 'emerald'],
            'completed' => ['value' => number_format(Appointment::where('status', 'completed')->count()), 'change' => '-1.2%', 'color' => 'rose'],
        ];

        $todaySchedule = Appointment::with(['patient', 'service'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_date', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->appointment_date)->format('H:00');
            });

        $latestVisits = Appointment::with(['patient', 'service'])
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->take(4)
            ->get();

        // Medical Reports Filtering Logic
        $reportsQuery = MedicalReport::with('patient')->latest();
        
        if ($request->filled('type') && $request->type !== 'all') {
            $reportsQuery->where('type', $request->type);
        }

        $medicalReports = $reportsQuery->paginate(5, ['*'], 'reports_page');
        
        // Append all parameters to maintain filter and tab state during pagination
        $medicalReports->appends($request->all());

        // Dynamic Report Types for filtering
        $reportTypes = MedicalReport::select('type')->distinct()->pluck('type');

        // All services for dynamic dropdowns
        $services = Service::all();

        $patients = User::where('role', 'patient')->latest()->paginate(8, ['*'], 'patients_page');
        $patients->appends($request->all());

        $pendingAppointments = Appointment::with(['patient', 'service'])
            ->where('status', 'pending')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('dashboard', compact(
            'stats', 
            'todaySchedule', 
            'latestVisits', 
            'medicalReports', 
            'patients', 
            'pendingAppointments',
            'reportTypes',
            'services'
        ));
    }

    protected function patientDashboard()
    {
        $user = auth()->user();

        $upcomingAppointment = Appointment::with('service')
            ->where('patient_id', $user->id)
            ->where('appointment_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->first();

        $pastAppointments = Appointment::with('service')
            ->where('patient_id', $user->id)
            ->where('appointment_date', '<', now())
            ->latest()
            ->take(5)
            ->get();

        $doctor = User::where('role', 'doctor')->first();
        $services = Service::all();

        // Appointment dates for mini-calendar highlighting
        $appointmentDates = Appointment::where('patient_id', $user->id)
            ->where('appointment_date', '>=', now()->startOfMonth())
            ->pluck('appointment_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->toArray();

        return view('patient.dashboard', compact(
            'upcomingAppointment',
            'pastAppointments',
            'doctor',
            'services',
            'appointmentDates'
        ));
    }

    /**
     * Store a new diagnosis and create a medical report.
     */
    public function storeDiagnosis(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'visit_category' => 'required|string',
            'symptoms' => 'required|string',
            'prescription' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        // 1. Create Medical Report
        MedicalReport::create([
            'report_id' => 'REP-' . rand(1000, 9999),
            'patient_id' => $appointment->patient_id,
            'type' => $request->visit_category,
            'report_date' => now(),
            'result_summary' => "Symptoms: " . $request->symptoms . "\n\nPrescription: " . $request->prescription,
        ]);

        // 2. Update Appointment Status
        $appointment->update([
            'status' => 'completed',
        ]);

        return redirect()->route('dashboard', ['tab' => 'diagnose'])->with('success', 'Consultation saved successfully');
    }

    public function downloadReport(MedicalReport $report)
    {
        $content = "MediSync Clinic - Medical Report\n";
        $content .= "--------------------------------\n";
        $content .= "Report ID: " . $report->report_id . "\n";
        $content .= "Patient: " . $report->patient->name . "\n";
        $content .= "Type: " . $report->type . "\n";
        $content .= "Date: " . $report->report_date->format('d M, Y') . "\n\n";
        $content .= "Summary:\n" . $report->result_summary . "\n";

        $fileName = "Report_" . $report->report_id . ".txt";

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $fileName);
    }

    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->route('appointments.index')->with('success', 'Notification marked as read');
    }
}
