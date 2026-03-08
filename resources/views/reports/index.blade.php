@extends('layouts.app')

@section('content')
<x-slot name="header">Laporan Kehadiran</x-slot>

<div class="space-y-6">
    <!-- Page Title & Intro -->
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Ringkasan Analitik
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Statistik kehadiran Anda di tahun {{ date('Y') }}.
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5">
        <!-- Total Attendance -->
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Absensi</p>
            <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">{{ $stats['total_attendance'] }}</p>
        </div>

        <!-- Present -->
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Hadir</p>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['total_present'] }}</p>
        </div>

        <!-- Late -->
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Telat</p>
            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $stats['total_late'] }}</p>
        </div>

        <!-- Absent -->
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tidak Hadir</p>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $stats['total_absent'] }}</p>
        </div>

        <!-- Leave -->
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Cuti</p>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $stats['total_leave'] }}</p>
        </div>
    </div>

    <!-- Monthly Progress Chart -->
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Kemajuan Kehadiran Bulanan</h3>
        <div class="relative h-80 w-full">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const canvas = document.getElementById("attendanceChart");

        // Stop jika canvas tidak ada
        if (!canvas) return;

        const ctx = canvas.getContext("2d");

        // Data dari Laravel Controller
        const labels = @json($labels);
        const data = @json($data);

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Attendance Count",
                    data: data,
                    backgroundColor: "rgba(79, 70, 229, 0.6)",
                    borderColor: "rgba(79, 70, 229, 1)",
                    borderWidth: 1,
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: "index",
                        intersect: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        },
                        grid: {
                            color: "rgba(156,163,175,0.1)"
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    });
</script>
@endsection