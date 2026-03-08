@extends('layouts.app')

@section('content')
<x-slot name="header">Data Karyawan</x-slot>

<div class="space-y-6">
    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Search -->
        <form method="GET" action="{{ route('employees.index') }}" class="relative max-w-sm w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                placeholder="Cari karyawan...">
        </form>

        <!-- Add Employee -->
        <a href="{{ route('employees.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg 
                  text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                  focus:ring-indigo-500 shadow-sm">
            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Karyawan
        </a>
    </div>

    <!-- Employees Table -->
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <!-- Name & Email -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 
                                                flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold">
                                        {{ strtoupper(substr($employee->user->name ?? '', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $employee->user->name ?? '-' }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $employee->user->email ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Department & Position -->
                        <td class="px-6 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $employee->department ?? '-' }}</div>
                        </td>

                        <!-- Role -->
                        <td class="px-6 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($employee->position) }}</td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $employee->status === 'inactive' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                {{ ucfirst($employee->status ?? 'active') }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('employees.edit', $employee->id) }}"
                                class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-green-100 dark:bg-green-700 text-green-600 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-600 transition"
                                title="Edit">
                                <!-- Pencil Icon -->
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z" />
                                </svg>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-red-100 dark:bg-red-700 text-red-600 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-600 transition"
                                    title="Delete"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                                    <!-- Trash Icon -->
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No employees found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection