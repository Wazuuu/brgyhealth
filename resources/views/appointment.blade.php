@extends('layouts.app')

@section('title', 'Make an Appointment')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-4xl font-extrabold text-gray-800 mb-8">🏥 Clinic Appointment Booking</h2>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-xl shadow-2xl mb-12 border-t-4 border-blue-500">
        <h3 class="text-2xl font-semibold text-gray-700 mb-6">Schedule New Appointment</h3>
        
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="appointmentDate" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                    <select name="appointmentTime" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="09:00">09:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="13:00">01:00 PM</option>
                        </select>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <textarea name="reason" rows="3" required class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>

    <h3 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">📅 Your Scheduled Appointments</h3>
    
    <div class="space-y-4">
        @forelse($appointments as $appt)
            <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-blue-500">
                <div class="flex justify-between">
                    <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }} at {{ $appt->time }}</p>
                    <span class="px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-800 rounded-full">
                        {{ $appt->status }}
                    </span>
                </div>
                <p class="text-gray-600 mt-2">{{ $appt->reason }}</p>
            </div>
        @empty
            <div class="p-6 bg-gray-100 rounded-xl text-center text-gray-500">
                You have no upcoming appointments.
            </div>
        @endforelse
    </div>
</div>
@endsection