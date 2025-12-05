@extends('layouts.app')

@section('title', 'Dashboard | Barangay Health')

@section('content')
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">📊 Dashboard Overview</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Total Residents</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalResidents }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-400">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Male (Adults)</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $menCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-pink-400">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Female (Adults)</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $womenCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-yellow-400">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Children (< 18)</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $childrenCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-pink-600">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Pregnant</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pregnantCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Health Issues</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $sickCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Resident Demographics</h3>
            <canvas id="demographicsChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Health Monitoring</h3>
            <canvas id="healthChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // --- 1. Demographics Pie Chart ---
        const ctxDemo = document.getElementById('demographicsChart').getContext('2d');
        new Chart(ctxDemo, {
            type: 'doughnut',
            data: {
                labels: ['Men', 'Women', 'Children'],
                datasets: [{
                    data: [{{ $menCount }}, {{ $womenCount }}, {{ $childrenCount }}],
                    backgroundColor: [
                        '#60A5FA', // Blue-400
                        '#F472B6', // Pink-400
                        '#FACC15'  // Yellow-400
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // --- 2. Health Status Bar Chart ---
        const ctxHealth = document.getElementById('healthChart').getContext('2d');
        new Chart(ctxHealth, {
            type: 'bar',
            data: {
                labels: ['Pregnant', 'Sick / Illness'],
                datasets: [{
                    label: 'Number of Residents',
                    data: [{{ $pregnantCount }}, {{ $sickCount }}],
                    backgroundColor: [
                        '#DB2777', // Pink-600
                        '#EF4444'  // Red-500
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Force whole numbers since you can't have 1.5 people
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide legend for simple bar chart
                    }
                }
            }
        });
    </script>
@endsection