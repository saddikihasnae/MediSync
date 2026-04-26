<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Get a list of appointments.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'service', 'doctor'])->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $appointments
        ]);
    }

    /**
     * Store a new appointment via API.
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

        return response()->json([
            'status' => 'success',
            'message' => 'Appointment booked successfully via API.',
            'data' => $appointment->load(['patient', 'service', 'doctor'])
        ], 201);
    }
}
