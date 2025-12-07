@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">💊 Medicine Inventory</h2>
    <a href="{{ route('admin.inventory.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
        + Add Medicine
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Item Name</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Stock Level</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Expires</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicines as $med)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <div class="font-bold text-gray-900">{{ $med->name }}</div>
                    <div class="text-xs text-gray-500">{{ Str::limit($med->description, 30) }}</div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    {{ $med->category }}
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <span class="font-bold text-lg {{ $med->stock <= 0 ? 'text-red-600' : ($med->stock < 20 ? 'text-orange-500' : 'text-green-600') }}">
                        {{ $med->stock }}
                    </span>
                    <span class="text-xs ml-1 px-2 py-0.5 rounded-full 
                        {{ $med->stock <= 0 ? 'bg-red-100 text-red-800' : ($med->stock < 20 ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                        {{ $med->status_attribute }}
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    {{ \Carbon\Carbon::parse($med->expiration_date)->format('M d, Y') }}
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.inventory.edit', $med->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('admin.inventory.destroy', $med->id) }}" method="POST" onsubmit="return confirm('Remove this item permanently?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-5 text-center text-gray-500">No medicines in inventory.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $medicines->links() }}</div>
</div>
@endsection