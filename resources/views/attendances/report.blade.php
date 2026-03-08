@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header & Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Laporan Absensi Karyawan</h2>
        <form method="GET" class="flex gap-2 items-center">
            <input type="date" name="date" value="{{ request('date') }}" 
                   class="h-10 rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            <button type="submit" 
                    class="h-10 px-4 py-2 rounded-lg border border-indigo-500 text-indigo-600 hover:bg-indigo-50 dark:text-indigo-400 dark:border-indigo-400 dark:hover:bg-gray-700 text-sm font-medium transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Karyawan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Check In</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Check Out</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                @forelse($attendances as $attendance)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $attendance->employee->user->name ?? '-' }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $attendance->employee->employee_id ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
                            {{ $attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : ($attendance->status === 'present' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300') }}">
                            {{ ucfirst($attendance->status ?? '-') }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i A') }}</td>
                    <td class="px-4 py-3">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i A') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No attendance records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection