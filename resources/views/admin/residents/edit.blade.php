@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Resident: {{ $resident->name }}</h2>

    <form action="{{ route('admin.residents.update', $resident->id) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                <input type="text" name="name" value="{{ $resident->name }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
                <input type="text" name="contact_number" value="{{ $resident->contact_number }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                <input type="number" name="age" value="{{ $resident->age }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                <select name="gender" required class="w-full border rounded px-3 py-2">
                    <option value="male" {{ $resident->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $resident->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <hr class="my-6 border-gray-200">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Health Information</h3>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Blood Type</label>
                <input type="text" name="blood_type" value="{{ $resident->blood_type }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Allergies</label>
                <input type="text" name="allergies" value="{{ $resident->allergies }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="flex space-x-6 mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_pregnant" value="1" {{ $resident->is_pregnant ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2 text-gray-700">Pregnant</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_sick" value="1" {{ $resident->is_sick ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-red-600">
                <span class="ml-2 text-gray-700">Currently Sick</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.residents') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">Update Resident</button>
        </div>
    </form>
</div>
@endsection