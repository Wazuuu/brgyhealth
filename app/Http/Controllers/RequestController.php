<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Show the user's current health records.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // 1. Simulate fetching the authenticated user's health record
        // In a real application, you would use Auth::id() and a database query here.
        $healthRecord = $this->getMockHealthRecord();

        // 2. Return the view, passing the health record data
        return view('request_changes', compact('healthRecord'));
    }

    /**
     * Mock function to generate sample health data for display.
     * * @return array
     */
    protected function getMockHealthRecord()
    {
        return [
            'blood_type' => 'O+',
            'last_verified' => '2024-05-15',
            'allergies' => ['Penicillin', 'Dust Mites'],
            'critical_allergies' => true,
            'status' => 'Active',
            'clearance' => 'Valid',
            'history' => [
                [
                    'date' => '2023-11-20',
                    'type' => 'Immunization',
                    'details' => 'Influenza Vaccine (Seasonal)',
                    'clinic' => 'Brgy. Health Center'
                ],
                [
                    'date' => '2024-03-01',
                    'type' => 'Check-up',
                    'details' => 'Routine annual check-up, no issues found.',
                    'clinic' => 'Dr. Reyes Private Clinic'
                ],
                [
                    'date' => '2024-05-15',
                    'type' => 'Diagnosis',
                    'details' => 'Tonsillitis (Prescribed Amoxicillin)',
                    'clinic' => 'Brgy. Health Center'
                ],
            ]
        ];
    }
}