<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold tracking-tight">Attendance Report</h2>
        <form method="GET" class="flex gap-2">
            <input type="date" name="date" value="{{ request('date') }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <x-ui.button type="submit" variant="outline">Filter</x-ui.button>
        </form>
    </div>

    <x-ui.card>
        <x-ui.table>
            <x-slot name="header">
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Employee</th>
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Check In</th>
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Check Out</th>
            </x-slot>
            @foreach($attendances as )
            <tr class="border-b transition-colors hover:bg-muted/50">
                <td class="p-4 align-middle">{{ ->date }}</td>
                <td class="p-4 align-middle">
                    <div class="flex flex-col">
                        <span class="font-medium">{{ ->employee->user->name }}</span>
                        <span class="text-xs text-muted-foreground">{{ ->employee->employee_id }}</span>
                    </div>
                </td>
                <td class="p-4 align-middle">{{ ucfirst(->status) }}</td>
                <td class="p-4 align-middle">{{ \Carbon\Carbon::parse(->check_in)->format('H:i A') }}</td>
                <td class="p-4 align-middle">{{ ->check_out ? \Carbon\Carbon::parse(->check_out)->format('H:i A') : '-' }}</td>
            </tr>
            @endforeach
        </x-ui.table>
        <div class="p-4">
            {{ ->links() }}
        </div>
    </x-ui.card>
</x-app-layout>