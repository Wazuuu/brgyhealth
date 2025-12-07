@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Resident</h2>

    <form action="{{ route('admin.residents.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
                <input type="text" name="contact_number" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                <input type="number" name="age" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                <select name="gender" required class="w-full border rounded px-3 py-2">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>

        <hr class="my-6 border-gray-200">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Health Information</h3>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Blood Type</label>
                <select name="blood_type" class="w-full border rounded px-3 py-2">
                    <option value="">Unknown</option>
                    <option value="A+">A+</option>
                    <option value="O+">O+</option>
                    <option value="B+">B+</option>
                    <option value="AB+">AB+</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Allergies</label>
                <input type="text" name="allergies" placeholder="e.g. Peanuts" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="flex space-x-6 mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_pregnant" value="1" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2 text-gray-700">Pregnant</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_sick" value="1" class="form-checkbox h-5 w-5 text-red-600">
                <span class="ml-2 text-gray-700">Currently Sick / Health Issue</span>
            </label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">Save Resident</button>
        </div>
    </form>
</div>
@endsection