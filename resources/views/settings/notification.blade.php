@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
            <a href="{{ route('settings.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pengaturan</a>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-900 dark:text-gray-100 font-medium">Notifikasi</span>
        </div>
        
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Notifikasi Anda</h2>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 p-4 rounded-lg text-sm border border-green-200 dark:border-green-800">
    {{ session('success') }}
</div>
@endif

<div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden max-w-4xl">
    <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-[600px] overflow-y-auto">
        
        @forelse($notifications as $notification)
            @php
                $is_unread = is_null($notification->read_at);
            @endphp
            <div class="p-5 flex gap-4 transition-colors {{ $is_unread ? 'bg-indigo-50/50 dark:bg-indigo-900/20 hover:bg-indigo-50 dark:hover:bg-indigo-900/40' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                
                <!-- Indikator Belum Dibaca -->
                <div class="flex-shrink-0 mt-1">
                    @if($is_unread)
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-600 dark:bg-indigo-400"></span>
                        </span>
                    @else
                        <span class="flex h-3 w-3 rounded-full bg-gray-200 dark:bg-gray-600"></span>
                    @endif
                </div>

                <!-- Konten Notifikasi -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                        <h4 class="text-sm font-semibold truncate {{ $is_unread ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $notification->title }}
                            @if(is_null($notification->user_id))
                                <span class="ml-2 px-2 py-0.5 rounded text-[10px] bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Pengumuman Umum</span>
                            @endif
                        </h4>
                        <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">
                        {{ $notification->content }}
                    </p>
                    
                    @if($is_unread)
                        <form action="{{ route('settings.notification.read', $notification->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                                Tandai dibaca
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <p class="text-base font-medium text-gray-900 dark:text-white">Belum ada notifikasi</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Anda akan menerima pemberitahuan di sini jika ada aktivitas baru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
