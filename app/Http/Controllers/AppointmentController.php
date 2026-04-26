<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Mail\AppointmentConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'service', 'doctor'])->latest();

        // Live Search (Axios)
        if ($request->ajax()) {
            if ($request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('patient', function($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%");
                });
            }
            return response()->json($query->get());
        }

        $appointments = $query->paginate(10);
        $patients = User::where('role', 'patient')->get();
        $doctors = User::where('role', 'doctor')->get();
        $services = Service::all();

        return view('appointments.index', compact('appointments', 'patients', 'doctors', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create($validated);

        // Send Email if confirmed
        if ($appointment->status === 'confirmed') {
            try {
                Mail::to($appointment->patient->email)->send(new AppointmentConfirmation($appointment));
            } catch (\Exception $e) {
                // Silently fail for seeder/local dev
            }
        }

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous créé avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}
