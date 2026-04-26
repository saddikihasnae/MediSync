<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(auth()->user()->role !== 'doctor', 403);

        $patients = User::where('role', 'patient')
            ->withCount(['patientAppointments as last_visit' => function($q) {
                $q->select(\DB::raw('max(appointment_date)'));
            }])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => User::where('role', 'patient')->count(),
            'new_this_month' => User::where('role', 'patient')->whereMonth('created_at', now()->month)->count(),
            'active_cases' => User::where('role', 'patient')->where('status', 'Under Treatment')->count(),
        ];

        return view('patients.index', compact('patients', 'stats'));
    }

    /**
     * Axios Search.
     */
    public function search(Request $request)
    {
        $query = User::where('role', 'patient');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }

        $patients = $query->withCount(['patientAppointments as last_visit' => function($q) {
            $q->select(\DB::raw('max(appointment_date)'));
        }])->get();

        return response()->json($patients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'doctor', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'status' => 'required|string',
        ]);

        User::create(array_merge($validated, [
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $patient)
    {
        abort_if(auth()->user()->role !== 'doctor', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'status' => 'required|string',
            'medical_note' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $patient)
    {
        abort_if(auth()->user()->role !== 'doctor', 403);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
