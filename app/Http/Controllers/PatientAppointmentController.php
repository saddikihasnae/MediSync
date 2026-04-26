<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PatientAppointmentController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create()
    {
        $services = Service::all();
        $doctor = User::where('role', 'doctor')->first();
        return view('patient.book', compact('services', 'doctor'));
    }

    /**
     * Store a new appointment request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $doctor = User::where('role', 'doctor')->first();

        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $doctor->id,
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        // Send confirmation email
        try {
            Mail::to(auth()->user()->email)->send(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            // Log error or ignore if mail server is not configured
        }

        return redirect()->route('dashboard')->with('success', __('messages.appointment_created') ?? 'Appointment booked successfully! We will review it soon.');
    }
}
