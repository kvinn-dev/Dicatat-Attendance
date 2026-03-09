@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengajuan Cuti</h2>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <!-- Request Form -->
    <div class="lg:col-span-1">
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/30 p-4 text-sm text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/30 p-4 text-sm text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <form action="{{ route('leave.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Izin</label>
                    <select name="type" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3">
                        <option value="Sick Leave">Cuti Sakit</option>
                        <option value="Annual Leave">Cuti Tahunan</option>
                        <option value="Personal Matter">Masalah Pribadi</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Berakhir</label>
                        <input type="date" name="end_date" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan</label>
                    <textarea name="reason" rows="3" class="block w-full rounded-lg border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" required></textarea>
                </div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit Request</button>
            </form>
        </div>
    </div>

    <!-- Leave History -->
    <div class="lg:col-span-2">
        <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Cuti</h3>
            </div>

            @forelse($leaves as $leave)
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $leave->type }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ $leave->reason }}</p>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                            {{ $leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                            {{ $leave->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                        ">
                        {{ ucfirst($leave->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                <div class="flex flex-col items-center justify-center py-8">
                    <svg class="h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p>Tidak ditemukan permintaan cuti.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection