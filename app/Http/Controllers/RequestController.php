<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HealthProfile;
use App\Models\ChangeRequest;

class RequestController extends Controller
{
    public function create()
    {
        // 1. Fetch the logged-in user's profile
        $healthProfile = HealthProfile::where('user_id', Auth::id())->first();

        // 2. Pass it to the view (it will be null if they are new)
        return view('request_changes', compact('healthProfile'));
    }

    public function store(Request $request)
{
    // 1. Validate
    $validated = $request->validate([
        'blood_type' => 'required|string|max:10',
        'allergies' => 'nullable|string',
        'critical_allergies' => 'nullable|boolean',
        // NEW VALIDATION
        'philhealth_number' => 'nullable|string|max:20',
        'emergency_contact_name' => 'required|string|max:255',
        'emergency_contact_phone' => 'required|string|max:20',
    ]);

    // 2. Convert allergies
    $allergiesArray = $validated['allergies'] 
        ? array_map('trim', explode(',', $validated['allergies'])) 
        : [];

    // 3. Create
    HealthProfile::create([
        'user_id' => Auth::id(),
        'blood_type' => $validated['blood_type'],
        'allergies' => $allergiesArray,
        'critical_allergies' => $request->has('critical_allergies'),
        'status' => 'Active',
        'clearance' => 'Pending Verification',
        'last_verified' => now(),
        // NEW FIELDS MAPPING
        'philhealth_number' => $validated['philhealth_number'],
        'emergency_contact_name' => $validated['emergency_contact_name'],
        'emergency_contact_phone' => $validated['emergency_contact_phone'],
    ]);

    return redirect()->back()->with('success', 'Health Profile created successfully!');
}
public function submitChange(Request $request)
    {
        // 1. Validate
        $request->validate([
            'request_type' => 'required|string',
            'details' => 'required|string',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB Max
        ]);

        // 2. Handle File Upload
        $path = null;
        if ($request->hasFile('document')) {
            // Stores in storage/app/public/documents
            $path = $request->file('document')->store('documents', 'public');
        }

        // 3. Save to Database
        ChangeRequest::create([
            'user_id' => Auth::id(),
            'request_type' => $request->request_type,
            'details' => $request->details,
            'document_path' => $path,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Request submitted successfully!');
    }
}