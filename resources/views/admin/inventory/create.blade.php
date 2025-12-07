@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Medicine</h2>

    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Medicine Name</label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select name="category" class="w-full border rounded px-3 py-2">
                    <option value="Analgesic">Analgesic</option>
                    <option value="Antibiotic">Antibiotic</option>
                    <option value="Antihistamine">Antihistamine</option>
                    <option value="Supplements">Supplements</option>
                    <option value="Herbal">Herbal</option>
                    <option value="First Aid">First Aid</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity</label>
                <input type="number" name="stock" required min="0" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Expiration Date</label>
                <input type="date" name="expiration_date" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.inventory.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">Save Item</button>
        </div>
    </form>
</div>
@endsection