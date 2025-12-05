@extends('layouts.app')

@section('title', 'Health Records | Barangay Health System')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($healthProfile)
    
        {{-- ================= EXISTING USER VIEW ================= --}}
        
        <h2 class="text-4xl font-extrabold text-gray-800 mb-8">
            🏥 Your Personal Health Records
        </h2>

        {{-- NEW ROW: Age, Height, Weight, BMI --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">Age</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthProfile->age }} <span class="text-sm text-gray-400 font-normal">yrs</span></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">Height</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthProfile->height }} <span class="text-sm text-gray-400 font-normal">cm</span></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">Weight</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthProfile->weight }} <span class="text-sm text-gray-400 font-normal">kg</span></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-teal-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">BMI Score</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($healthProfile->bmi, 1) }}</p>
                <div class="mt-1 text-xs font-bold 
                    {{ $healthProfile->bmi < 18.5 ? 'text-blue-500' : 
                      ($healthProfile->bmi < 25 ? 'text-green-500' : 
                      ($healthProfile->bmi < 30 ? 'text-orange-500' : 'text-red-500')) }}">
                    @if($healthProfile->bmi < 18.5) Underweight
                    @elseif($healthProfile->bmi < 25) Normal
                    @elseif($healthProfile->bmi < 30) Overweight
                    @else Obese
                    @endif
                </div>
            </div>
        </div>

        {{-- Existing Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">Blood Type</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthProfile->blood_type }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-pink-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">Allergies</h3>
                <p class="text-xl font-bold text-gray-900 mt-2">
                    {{ $healthProfile->allergies ? implode(', ', $healthProfile->allergies) : 'None' }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase">Status</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthProfile->status }}</p>
            </div>
        </div>

        {{-- Request Form Section (Keep existing code here) --}}
        <div class="bg-gray-50 p-8 rounded-xl border border-gray-200 mt-12 shadow-inner">
             {{-- ... existing request form code ... --}}
             <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">📋 Request Updates or Changes</h3>
                    <p class="text-gray-600 text-sm">Need to update your info, add a family member, or archive a record?</p>
                </div>
                <button onclick="document.getElementById('requestForm').classList.toggle('hidden')" 
                        class="bg-gray-800 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition shadow-md flex items-center">
                    <span>New Request</span>
                    <span class="ml-2">▼</span>
                </button>
            </div>

            <div id="requestForm" class="hidden bg-white p-6 rounded-lg shadow-lg border border-gray-100">
                <form action="{{ route('requests.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">What would you like to do?</label>
                        <select name="request_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Update Personal Record">✏️ Update My Personal Record</option>
                            <option value="Add Resident">➕ Request to Add a New Resident</option>
                            <option value="Archive Resident">📂 Request to Archive a Resident</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Details / Reason</label>
                        <textarea name="details" rows="4" required 
                                  placeholder="Please provide specific details. E.g., 'Correct spelling of my name' or 'Adding newborn baby: [Name]'"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Attach Supporting Document (Optional)
                            <span class="block text-xs font-normal text-gray-500">Accepted: JPG, PNG, PDF (Max 2MB). E.g., Birth Certificate, ID.</span>
                        </label>
                        <input type="file" name="document" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else

        {{-- ================= NEW USER FORM VIEW ================= --}}
        
        <div class="max-w-2xl mx-auto mt-10">
            <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-blue-600">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-800">Complete Your Profile</h2>
                    <p class="text-gray-500 mt-2">It looks like you are new here! Please fill out your initial health record to proceed.</p>
                </div>

                <form action="{{ route('health_profile.store') }}" method="POST">
                    @csrf
                    
                    {{-- NEW: Age, Height, Weight --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                            <input type="number" name="age" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                            <input type="number" step="0.01" id="height" name="height" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="170">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" step="0.01" id="weight" name="weight" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="65">
                        </div>
                    </div>

                    {{-- Live BMI Calculation Preview --}}
                    <div class="mb-6 p-3 bg-blue-50 rounded-lg text-center hidden" id="bmiPreview">
                        <span class="text-sm text-gray-600">Estimated BMI:</span>
                        <span class="font-bold text-blue-700 text-lg" id="bmiValue">--</span>
                    </div>

                    <script>
                        const hInput = document.getElementById('height');
                        const wInput = document.getElementById('weight');
                        const preview = document.getElementById('bmiPreview');
                        const val = document.getElementById('bmiValue');

                        function calcBMI() {
                            const h = parseFloat(hInput.value) / 100; // cm to m
                            const w = parseFloat(wInput.value);
                            if(h > 0 && w > 0) {
                                const bmi = (w / (h * h)).toFixed(1);
                                val.innerText = bmi;
                                preview.classList.remove('hidden');
                            }
                        }
                        hInput.addEventListener('input', calcBMI);
                        wInput.addEventListener('input', calcBMI);
                    </script>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Blood Type</label>
                        <select name="blood_type" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="" disabled selected>Select Blood Type</option>
                            <option value="Unknown">I don't know</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allergies (Optional)</label>
                        <input type="text" name="allergies" placeholder="e.g. Peanuts, Penicillin, Dust"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-8 flex items-center">
                        <input type="checkbox" id="critical" name="critical_allergies" value="1" 
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="critical" class="ml-2 text-sm text-gray-700">
                            Are any of these allergies <span class="font-bold text-red-600">life-threatening?</span>
                        </label>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">PhilHealth Number (Optional)</label>
                        <input type="text" name="philhealth_number" placeholder="XX-XXXXXXXXX-X"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                        <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase">In Case of Emergency</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Name</label>
                                <input type="text" name="emergency_contact_name" required placeholder="Full Name"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                <input type="text" name="emergency_contact_phone" required placeholder="09XXXXXXXXX"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200">
                        Save Health Profile
                    </button>
                </form>
            </div>
        </div>

    @endif

</div>
@endsection