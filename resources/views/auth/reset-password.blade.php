@extends('layout')

@section('content')
<div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Reset Password</h1>
        <p class="text-gray-500">Enter the code sent to {{ $email }}</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">OTP Code</label>
            <input type="text" name="otp" placeholder="123456" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center tracking-widest" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
            Reset Password
        </button>
    </form>
</div>
@endsection