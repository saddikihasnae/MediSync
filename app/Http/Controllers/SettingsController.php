<?php

namespace App\Http\Controllers;

use App\Models\ClinicSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $clinicSettings = ClinicSetting::all()->pluck('value', 'key');
        return view('settings.index', compact('clinicSettings'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'specialty' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['name', 'email', 'specialty']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->back()->with([
            'success' => 'Profile updated successfully.',
            'active_tab' => 'profile'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        // Forced update using ID and immediate logout to clear session
        $user = User::where('id', Auth::id())->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            
            // Logout user to force re-authentication with new password
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Password changed successfully. Please login with your new password.');
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    public function updateClinic(Request $request)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'clinic_phone' => 'required|string|max:50',
            'clinic_address' => 'required|string|max:500',
            'working_hours_from' => 'required',
            'working_hours_to' => 'required',
        ]);

        foreach ($request->only(['clinic_name', 'clinic_phone', 'clinic_address', 'working_hours_from', 'working_hours_to']) as $key => $value) {
            ClinicSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with([
            'success' => 'Clinic details updated successfully.',
            'active_tab' => 'clinic'
        ]);
    }
}
