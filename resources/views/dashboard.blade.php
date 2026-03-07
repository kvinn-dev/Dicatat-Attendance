<x-app-layout>
    <div class="flex items-center justify-between space-y-2 mb-6">
        <h2 class="text-3xl font-bold tracking-tight">Dashboard</h2>
        
        @if(auth()->user()->role === 'employee')
            <div class="flex gap-2">
                <form action="{{ route('attendance.checkIn') }}" method="POST">
                    @csrf
                    <x-ui.button>Check In</x-ui.button>
                </form>
                <form action="{{ route('attendance.checkOut') }}" method="POST">
                    @csrf
                    <x-ui.button variant="secondary">Check Out</x-ui.button>
                </form>
            </div>
        @endif
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <x-ui.card>
            <div class="text-sm font-medium text-muted-foreground">Total Employees</div>
            <div class="text-2xl font-bold">{{ $stats['total_employees'] }}</div>
        </x-ui.card>
        <x-ui.card>
            <div class="text-sm font-medium text-muted-foreground">Present Today</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['present_today'] }}</div>
        </x-ui.card>
        <x-ui.card>
            <div class="text-sm font-medium text-muted-foreground">Late Today</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['late_today'] }}</div>
        </x-ui.card>
        <x-ui.card>
            <div class="text-sm font-medium text-muted-foreground">Absent Today</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['absent_today'] }}</div>
        </x-ui.card>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8">
        <x-ui.card>
            <h3 class="font-semibold leading-none tracking-tight mb-4">Recent Attendance</h3>
            <x-ui.table>
                <x-slot name="header">
                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Employee</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Check In</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Check Out</th>
                </x-slot>
                @foreach($recent_attendances as $attendance)
                <tr class="border-b transition-colors hover:bg-muted/50">
                    <td class="p-4 align-middle">{{ $attendance->employee->user->name }}</td>
                    <td class="p-4 align-middle">
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2
                            {{ $attendance->status === 'present' ? 'border-transparent bg-green-100 text-green-800' : '' }}
                            {{ $attendance->status === 'late' ? 'border-transparent bg-yellow-100 text-yellow-800' : '' }}
                        ">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                    <td class="p-4 align-middle">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i A') }}</td>
                    <td class="p-4 align-middle">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i A') : '-' }}</td>
                </tr>
                @endforeach
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>