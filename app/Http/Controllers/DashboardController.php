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
    public function index()
    {
        $today = Carbon::today();
        
        // Overview Stats
        $totalPatients = User::where('role', 'patient')->count();
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', $today)->count();
        $activeServicesCount = Service::count();
        $completedAppointmentsCount = Appointment::where('status', 'completed')->count();

        $stats = [
            'total_patients' => ['value' => number_format($totalPatients), 'change' => '+12.5%', 'color' => 'indigo'],
            'today_appointments' => ['value' => number_format($todayAppointmentsCount), 'change' => '+4.3%', 'color' => 'blue'],
            'active_services' => ['value' => number_format($activeServicesCount), 'change' => '+0.0%', 'color' => 'emerald'],
            'completed' => ['value' => number_format($completedAppointmentsCount), 'change' => '-1.2%', 'color' => 'rose'],
        ];

        // Today's Schedule for Overview
        $todaySchedule = Appointment::with(['patient', 'service'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_date', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->appointment_date)->format('H:00');
            });

        // Latest Visits for Overview
        $latestVisits = Appointment::with(['patient', 'service'])
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->take(4)
            ->get();

        // Medical Reports Tab
        $medicalReports = MedicalReport::with('patient')->latest()->take(10)->get();

        // Patients Overview Tab
        $patients = User::where('role', 'patient')->latest()->take(12)->get();

        // Diagnose Tab (Pending Appointments)
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
            'pendingAppointments'
        ));
    }

    /**
     * Complete a diagnosis and update appointment status.
     */
    public function completeDiagnosis(Request $request, Appointment $appointment)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
        ]);

        $appointment->update([
            'status' => 'completed',
            'notes' => $request->diagnosis . "\n\nPrescription: " . $request->prescription,
        ]);

        return redirect()->back()->with('success', 'Diagnosis saved and appointment completed.');
    }
}
