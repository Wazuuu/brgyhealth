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
            {{-- Handle array or string for allergies --}}
            @if(is_array($healthProfile->allergies))
                {{ implode(', ', $healthProfile->allergies) }}
            @else
                {{ $healthProfile->allergies ?? 'None' }}
            @endif
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase">Status</h3>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthProfile->status }}</p>
    </div>
</div>

{{-- Request Form Section --}}
<div class="bg-gray-50 p-8 rounded-xl border border-gray-200 mt-12 shadow-inner">
     <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">📋 Request Updates or Changes</h3>
            <p class="text-gray-600 text-sm">Need to update your info, add a family member, or archive a record?</p>
        </div>
        <button type="button" onclick="document.getElementById('requestForm').classList.toggle('hidden')" 
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