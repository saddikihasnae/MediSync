<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource with Weekly Calendar View.
     */
    public function index(Request $request)
    {
        // Default: Show this week's appointments (Monday to Saturday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $startOfWeek->copy()->addDays(5)->endOfDay();
        
        $appointments = Appointment::with(['patient', 'service'])
            ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
            ->get()
            ->groupBy(function($app) {
                return Carbon::parse($app->appointment_date)->format('l'); // Group by Day Name
            });

        $patients = User::where('role', 'patient')->get();
        $doctors = User::where('role', 'doctor')->get();
        $services = Service::all();

        return view('appointments.index', compact('appointments', 'patients', 'doctors', 'services', 'startOfWeek'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
        ]);

        $doctor = User::where('role', 'doctor')->first();

        Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctor->id,
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.index')->with('success', __('messages.appointment_created'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', __('messages.appointment_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', __('messages.appointment_deleted'));
    }

    /**
     * Axios Search logic.
     */
    public function search(Request $request)
    {
        $query = Appointment::with(['patient', 'service']);

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $appointments = $query->get();
        $grouped = $appointments->groupBy(function($app) {
            return Carbon::parse($app->appointment_date)->format('l');
        });

        return response()->json($grouped);
    }
}
