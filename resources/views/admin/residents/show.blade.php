@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.residents') }}" class="text-gray-600 hover:text-gray-900">← Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- Header --}}
        <div class="bg-gray-800 p-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold">{{ $resident->name }}</h2>
                <p class="text-gray-400 mt-1">ID: #{{ $resident->id }} | Status: {{ $resident->status }}</p>
            </div>
            <div class="text-right">
                <p class="text-xl">{{ $resident->age }} Years Old</p>
                <p class="text-gray-400 capitalize">{{ $resident->gender }}</p>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">🏥 Health Profile</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500">
                    <span class="block text-gray-500 text-sm uppercase">Blood Type</span>
                    <span class="block text-3xl font-bold text-gray-800">{{ $resident->blood_type ?? 'Unknown' }}</span>
                </div>
                <div class="bg-pink-50 p-6 rounded-lg border-l-4 border-pink-500">
                    <span class="block text-gray-500 text-sm uppercase">Allergies</span>
                    <span class="block text-xl font-bold text-gray-800">{{ $resident->allergies ?? 'None' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-bold text-gray-700 mb-2">Condition Status</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center justify-between p-3 rounded bg-gray-50">
                            <span>Pregnant</span>
                            @if($resident->is_pregnant)
                                <span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs font-bold">YES</span>
                            @else
                                <span class="text-gray-400">No</span>
                            @endif
                        </li>
                        <li class="flex items-center justify-between p-3 rounded bg-gray-50">
                            <span>Sick / Illness</span>
                            @if($resident->is_sick)
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">YES</span>
                            @else
                                <span class="text-gray-400">No</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700 mb-2">Contact Info</h4>
                    <div class="p-4 bg-gray-50 rounded text-gray-700">
                        <p><strong>Phone:</strong> {{ $resident->contact_number ?? 'N/A' }}</p>
                        <p><strong>Registered:</strong> {{ $resident->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.residents.edit', $resident->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded mr-2">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection