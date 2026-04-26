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
        $user = auth()->user();

        if ($user->role === 'doctor') {
            return $this->doctorDashboard();
        }

        return $this->patientDashboard();
    }

    protected function doctorDashboard()
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

        $medicalReports = MedicalReport::with('patient')->latest()->take(10)->get();
        $patients = User::where('role', 'patient')->latest()->take(12)->get();
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
