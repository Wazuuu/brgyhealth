@extends('layout')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
    <p class="text-gray-700 mb-4">You are logged in!</p>
    
    <div class="bg-blue-50 p-4 rounded border-l-4 border-blue-500">
        <p><strong>User Info:</strong></p>
        <ul class="list-disc ml-5 mt-2">
            <li>Name: {{ Auth::user()->name }}</li>
            <li>Email: {{ Auth::user()->email }}</li>
        </ul>
    </div>
</div>
@endsection