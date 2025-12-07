<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Appointment;
use App\Models\ChangeRequest;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Reuse the logic from HomeController for stats
        $totalResidents = Resident::count();
        $menCount = Resident::where('gender', 'male')->where('age', '>=', 18)->count();
        $womenCount = Resident::where('gender', 'female')->where('age', '>=', 18)->count();
        $childrenCount = Resident::where('age', '<', 18)->count();
        $pregnantCount = Resident::where('is_pregnant', true)->count();
        $sickCount = Resident::where('is_sick', true)->count();

        return view('admin.dashboard', compact(
            'totalResidents', 'menCount', 'womenCount', 
            'childrenCount', 'pregnantCount', 'sickCount'
        ));
    }

    public function residents()
    {
        // Only show Active residents by default
        $residents = Resident::where('status', 'Active')->latest()->paginate(10);
        return view('admin.residents', compact('residents'));
    }

    public function archivedResidents()
    {
        $residents = Resident::where('status', 'Archived')->latest()->paginate(10);
        return view('admin.residents.archived', compact('residents'));
    }
    public function appointments()
    {
        // Get all appointments with user details
        $appointments = Appointment::with('user')->orderBy('date', 'asc')->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function approveAppointment($id)
    {
        Appointment::findOrFail($id)->update(['status' => 'Approved']);
        return back()->with('success', 'Appointment Approved');
    }

    public function requests()
    {
        $requests = ChangeRequest::with('user')->where('status', 'Pending')->get();
        return view('admin.requests', compact('requests'));
    }

    public function approveRequest($id)
    {
        ChangeRequest::findOrFail($id)->update(['status' => 'Approved']);
        return back()->with('success', 'Request Approved');
    }
}