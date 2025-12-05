<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        // Fetch appointments from local DB for the logged-in user
        $appointments = Appointment::where('user_id', Auth::id())
                                   ->orderBy('date', 'desc')
                                   ->get();

        return view('appointment', compact('appointments'));
    }

    public function store(Request $request)
    {
        // 1. Validate inputs
        $request->validate([
            'appointmentDate' => 'required|date',
            'appointmentTime' => 'required',
            'reason' => 'required|string',
        ]);

        // 2. Save to local SQL database
        Appointment::create([
            'user_id' => Auth::id(),
            'date' => $request->appointmentDate,
            'time' => $request->appointmentTime,
            'reason' => $request->reason,
            'status' => 'Pending'
        ]);

        // 3. Redirect back with success message
        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }
}