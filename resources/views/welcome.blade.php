<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Health System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('head')
</head>
<body class="bg-gray-100 font-sans">

    @if(session('success'))
        <!-- Success Message Popup -->
        <div id="success-alert" class="fixed top-5 right-5 z-50 p-4 bg-green-500 text-white rounded-lg shadow-xl transition-opacity duration-300" 
             style="animation: fadeout 5s forwards;">
            {{ session('success') }}
        </div>
        <script>
            // Simple JS to hide the alert after 4 seconds
            setTimeout(() => {
                document.getElementById('success-alert').style.opacity = '0';
            }, 4000);
            setTimeout(() => {
                document.getElementById('success-alert').style.display = 'none';
            }, 5000);
        </script>
    @endif

    <div class="flex h-screen overflow-hidden">
        
        <!-- LEFT SIDEBAR NAVBAR -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full z-10">
            <div class="p-6 text-center border-b border-gray-800">
                <h1 class="text-2xl font-bold text-blue-400">Barangay App</h1>
                <p class="text-xs text-gray-500 mt-1">Health & Records</p>
            </div>

            Navigation Links (Includes active state logic)
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('home') }}" class="block py-2.5 px-4 rounded transition duration-200 
                    @if(request()->routeIs('home')) bg-gray-700 text-white @else hover:bg-gray-800 @endif">
                    📊 Dashboard
                </a>
                <a href="{{ route('appointments.create') }}" class="block py-2.5 px-4 rounded transition duration-200 
                    @if(request()->routeIs('appointments.*')) bg-gray-700 text-white @else hover:bg-gray-800 @endif">
                    👥 Make an Appointment
                </a>
                <a href="{{ route('requests.create') }}" class="block py-2.5 px-4 rounded transition duration-200 
                    @if(request()->routeIs('requests.*')) bg-gray-700 text-white @else hover:bg-gray-800 @endif">
                    🏥 Health Records
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800 text-gray-400">
                    ⚙️ Settings
                </a>
            </nav>
            <!-- End Navigation Links -->

            <div class="p-4 border-t border-gray-800">
                @auth
                    <div class="mb-4 text-sm text-gray-400">
                        Logged in as <span class="text-white font-bold">{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Logout
                        </button>
                    </form>
                @else
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="block w-full bg-transparent border border-gray-500 hover:border-white text-gray-300 hover:text-white text-center font-bold py-2 px-4 rounded">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 ml-64 p-8 overflow-y-auto h-screen">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
            
        </main>
    </div>
</body>
</html>