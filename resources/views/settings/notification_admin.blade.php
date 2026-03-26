@extends('layouts.app')

@section('content')
<div x-data="{ showEditModal: false, editData: { id: '', title: '', content: '' } }">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
                <a href="{{ route('settings.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ __('settings/notification.breadcrumb-before') }}</a>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ __('settings/notification.breadcrumb-now') }}</span>
            </div>
            
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ __('settings/notification.title-admin') }}</h2>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 p-4 rounded-lg text-sm border border-green-200 dark:border-green-800">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Buat Notifikasi -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('settings/notification.new-notification.label') }}</h3>
                <form action="{{ route('settings.notification.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('settings/notification.new-notification.notification-title') }}</label>
                        <input type="text" name="title" required class="w-full rounded-lg border border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('settings/notification.new-notification.notification-message') }}</label>
                        <textarea name="content" rows="4" required class="w-full rounded-lg border border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                        <p class="text-xs text-gray-500 mt-1">{{ __('settings/notification.new-notification.description') }}</p>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-sm text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        {{ __('settings/notification.new-notification.send') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Notifikasi Terkirim -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('settings/notification.notification-list.label-admin') }}</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-[600px] overflow-y-auto">
                    @forelse($notifications as $notification)
                        <div class="p-5 flex flex-col sm:flex-row gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $notification->title }}</h4>
                                    @if(is_null($notification->user_id))
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">{{ __('settings/notification.notification-list.all') }}</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $notification->content }}</p>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }} ({{ $notification->created_at->format('d M Y, H:i') }})</span>
                            </div>
                            <div class="flex items-start gap-2 mt-2 sm:mt-0">
                                <!-- Tombol Edit -->
                                <button @click="editData = { id: {{ $notification->id }}, title: '{{ addslashes($notification->title) }}', content: '{{ addslashes(preg_replace('/\r|\n/', ' ', $notification->content)) }}' }; showEditModal = true"
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/30 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z" /></svg>
                                </button>
                                <!-- Form Delete -->
                                <form action="{{ route('settings.notification.delete', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/30 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada notifikasi yang dikirim.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (Alpine.js) -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div @click.away="showEditModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md shadow-lg transform transition-all">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Edit Notifikasi</h3>
            
            <form :action="`/settings/notification/admin/${editData.id}`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Notifikasi</label>
                    <input type="text" name="title" x-model="editData.title" required class="w-full rounded-lg border border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Pesan</label>
                    <textarea name="content" x-model="editData.content" rows="4" required class="w-full rounded-lg border border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
