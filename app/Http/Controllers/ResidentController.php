<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    // Show Create Form
    public function create()
    {
        return view('admin.residents.create');
    }

    // Store New Resident
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'contact_number' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        Resident::create([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'contact_number' => $request->contact_number,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'is_pregnant' => $request->has('is_pregnant'),
            'is_sick' => $request->has('is_sick'),
            'status' => 'Active',
        ]);

        return redirect()->route('admin.residents')->with('success', 'Resident added successfully!');
    }

    // Show Profile (Read)
    public function show($id)
    {
        $resident = Resident::findOrFail($id);
        return view('admin.residents.show', compact('resident'));
    }

    // Show Edit Form
    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('admin.residents.edit', compact('resident'));
    }

    // Update Resident
    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
        ]);

        $resident->update([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'contact_number' => $request->contact_number,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'is_pregnant' => $request->has('is_pregnant'),
            'is_sick' => $request->has('is_sick'),
        ]);

        return redirect()->route('admin.residents')->with('success', 'Resident profile updated!');
    }

    // Archive Resident
    public function archive($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->update(['status' => 'Archived']);
        
        return redirect()->route('admin.residents')->with('success', 'Resident archived successfully.');
    }

    // Restore Archived Resident
    public function restore($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->update(['status' => 'Active']);
        
        return redirect()->route('admin.residents')->with('success', 'Resident restored successfully!');
    }
}