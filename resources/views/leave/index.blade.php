@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, selectedLeave: null }">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengajuan Cuti</h2>
    </div>

    <!-- Form Pengajuan (Hanya untuk Employee) -->
    @if(auth()->user()->role === 'employee')
    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Buat Pengajuan Baru</h3>
        <form action="{{ route('leave.store') }}" method="POST" class="grid gap-6 md:grid-cols-2">
            @csrf
            <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Izin</label>
                <select name="type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="sick">Sakit</option>
                    <option value="leave">Cuti Tahunan</option>
                    <option value="permit">Izin Lainnya</option>
                </select>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mulai Tanggal</label>
                <input type="date" name="start_date" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan</label>
                <textarea name="reason" rows="3" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="col-span-2">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
    @endif

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 p-4 rounded-lg text-sm border border-green-200 dark:border-green-800">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table History / List -->
    <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    @if(auth()->user()->role === 'admin')
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Karyawan</th>
                    @endif
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Jenis</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Alasan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                @forelse($leaves as $leave)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    @if(auth()->user()->role === 'admin')
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900 dark:text-white">{{ $leave->employee->user->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $leave->employee->employee_id ?? '' }}</div>
                    </td>
                    @endif
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300 capitalize">{{ $leave->type }}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm max-w-xs truncate">{{ $leave->reason }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
                            {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                            {{ $leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                            {{ $leave->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                            {{ $leave->status_label }}
                        </span>
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td class="px-4 py-3">
                        <div class="flex gap-2">

                            @if(auth()->user()->role === 'admin' && $leave->status === 'pending')

                            <!-- Accept -->
                            <form action="{{ route('leave.update', $leave->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button
                                    type="submit"
                                    class="flex items-center justify-center h-6 w-14 text-xs font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition">
                                    Accept
                                </button>
                            </form>

                            <!-- Decline -->
                            <form action="{{ route('leave.update', $leave->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button
                                    type="submit"
                                    class="flex items-center justify-center h-6 w-14 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition">
                                    Decline
                                </button>
                            </form>

                            @endif

                            <!-- Detail -->
                            <button
                                @click="selectedLeave = {{ json_encode($leave) }}; showModal = true"
                                class="flex items-center justify-center h-6 w-14 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                                Detail
                            </button>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? '6' : '4' }}" class="px-4 py-4 text-center text-gray-500">Belum ada data pengajuan cuti.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div
            x-show="showModal"
            x-cloak
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md shadow-lg">

                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                    Detail Pengajuan Cuti
                </h3>

                <template x-if="selectedLeave">
                    <div class="space-y-4 text-sm">

                        <!-- Jenis -->
                        <div class="flex justify-between items-start border-b pb-2 border-gray-200 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Jenis Izin</span>
                            <span class="font-medium text-gray-900 dark:text-white capitalize"
                                x-text="selectedLeave.type === 'leave' ? 'Cuti Tahunan' :
                        selectedLeave.type === 'sick' ? 'Sakit' :
                        'Izin Lainnya'">
                            </span>
                        </div>

                        <!-- Periode -->
                        <div class="flex justify-between items-start border-b pb-2 border-gray-200 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Periode</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                <span x-text="selectedLeave.start_date"></span>
                                -
                                <span x-text="selectedLeave.end_date"></span>
                            </span>
                        </div>

                        <!-- Status -->
                        <div class="flex justify-between items-center border-b pb-2 border-gray-200 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Status</span>

                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full"
                                :class="{
                    'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300': selectedLeave.status === 'approved',
                    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300': selectedLeave.status === 'pending',
                    'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300': selectedLeave.status === 'rejected'}"
                                x-text="selectedLeave.status.charAt(0).toUpperCase() + selectedLeave.status.slice(1)">
                            </span>

                        </div>

                        <!-- Alasan -->
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 block mb-2">Alasan</span>
                            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 leading-relaxed">
                                <p x-text="selectedLeave.reason"></p>
                            </div>
                        </div>

                    </div>
                </template>

                <div class="mt-6 flex justify-end">
                    <button
                        @click="showModal=false"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection