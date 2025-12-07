@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-bold mb-6">📅 Appointment Requests</h2>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Date/Time</th>
                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Reason</th>
                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appt)
            <tr>
                <td class="px-5 py-5 border-b bg-white text-sm">{{ $appt->user->name }}</td>
                <td class="px-5 py-5 border-b bg-white text-sm">{{ $appt->date }} <br> {{ $appt->time }}</td>
                <td class="px-5 py-5 border-b bg-white text-sm">{{ $appt->reason }}</td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $appt->status === 'Approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $appt->status }}
                    </span>
                </td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    @if($appt->status !== 'Approved')
                    <form action="{{ route('admin.appointments.approve', $appt->id) }}" method="POST">
                        @csrf
                        <button class="text-green-600 hover:text-green-900 font-bold">Approve</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection