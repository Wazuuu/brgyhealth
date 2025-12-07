<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full z-10">
            <div class="p-6 text-center border-b border-gray-800">
                <h1 class="text-2xl font-bold text-red-500">ADMIN PANEL</h1>
                <p class="text-xs text-gray-500 mt-1">Barangay System</p>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.residents') }}" class="block py-2.5 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.residents') ? 'bg-gray-700' : '' }}">
                    👥 Residents List
                </a>
                
                {{-- NEW LINK --}}
                <a href="{{ route('admin.residents.archived') }}" class="block py-2.5 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.residents.archived') ? 'bg-gray-700' : '' }}">
                    📂 Archived Residents
                </a>

                <a href="{{ route('admin.appointments') }}" class="block py-2.5 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.appointments') ? 'bg-gray-700' : '' }}">
                    📅 Appointment Requests
                </a>
                <a href="{{ route('admin.requests') }}" class="block py-2.5 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.requests') ? 'bg-gray-700' : '' }}">
                    📋 Change Requests
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <div class="mb-4 text-sm text-gray-400">Admin: {{ Auth::user()->name }}</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full bg-red-600 hover:bg-red-700 font-bold py-2 px-4 rounded">Logout</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8 overflow-y-auto h-screen">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    @yield('scripts')
</body>
</html>