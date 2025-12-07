@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">📂 Archived Residents</h2>
    <a href="{{ route('admin.residents') }}" class="text-blue-600 hover:underline">
        ← Back to Active List
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Age / Gender</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Reason/Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($residents as $resident)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <div class="font-bold text-gray-900">{{ $resident->name }}</div>
                    <div class="text-xs text-gray-500">{{ $resident->contact_number ?? 'No contact' }}</div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    {{ $resident->age }} / <span class="capitalize">{{ $resident->gender }}</span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-xs font-bold">Archived</span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <div class="flex space-x-2">
                        {{-- View Profile --}}
                        <a href="{{ route('admin.residents.show', $resident->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                        
                        <span class="text-gray-300">|</span>
                        
                        {{-- Edit --}}
                        <a href="{{ route('admin.residents.edit', $resident->id) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Edit</a>
                        
                        <span class="text-gray-300">|</span>
                        
                        {{-- Restore Button --}}
                        <form action="{{ route('admin.residents.restore', $resident->id) }}" method="POST" onsubmit="return confirm('Restore this resident to the active list?');">
                            @csrf
                            <button class="text-green-600 hover:text-green-900 font-medium">Restore</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                    No archived residents found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $residents->links() }}</div>
</div>
@endsection