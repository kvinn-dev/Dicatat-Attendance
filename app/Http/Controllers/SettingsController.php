<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function system_setting()
    {
        $settings = [
            'work_start_time' => \App\Models\Setting::get('work_start_time', '09:00'),
            'work_end_time' => \App\Models\Setting::get('work_end_time', '17:00'),
            'work_days' => json_decode(\App\Models\Setting::get('work_days', '["1","2","3","4","5"]'), true) ?? [],
        ];
        return view('settings.system_setting', compact('settings'));
    }

    public function update_system_setting(Request $request)
    {
        $request->validate([
            'language' => 'nullable|in:id,en',
            'theme' => 'nullable|in:light,dark,system',
            'work_start_time' => 'nullable|date_format:H:i',
            'work_end_time' => 'nullable|date_format:H:i',
            'work_days' => 'nullable|array',
        ]);

        // Hanya Admin yang dapat menyimpan pengaturan jadwal kerja
        if (auth()->user()->role === 'admin') {
            if ($request->has('work_start_time')) \App\Models\Setting::set('work_start_time', $request->work_start_time);
            if ($request->has('work_end_time')) \App\Models\Setting::set('work_end_time', $request->work_end_time);
            if ($request->has('work_days')) {
                // Simpan hari dalam format JSON
                \App\Models\Setting::set('work_days', json_encode($request->work_days));
            }
        }

        return back()->with('success', 'Pengaturan sistem berhasil disimpan.');
    }

    // ==========================================
    // ADMIN NOTIFICATION METHODS
    // ==========================================
    public function notificationAdmin()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('settings.notification_admin', compact('notifications'));
    }

    public function storeNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Gunakan create() langsung, model sudah ada $fillable
        Notification::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => null, // global untuk semua karyawan
        ]);

        return back()->with('success', 'Notifikasi global berhasil dikirim ke semua karyawan.');
    }

    public function updateNotification(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'content' => 'required|string']);
        Notification::findOrFail($id)->update($request->only('title', 'content'));
        return back()->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function deleteNotification($id)
    {
        Notification::findOrFail($id)->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    // ==========================================
    // EMPLOYEE NOTIFICATION METHODS
    // ==========================================
    public function notificationEmployee()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
            ->orWhereNull('user_id')->orderBy('created_at', 'desc')->get();
        return view('settings.notification', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        Notification::where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhereNull('user_id');
        })->whereNull('read_at')->update(['read_at' => now()]);
        
        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }
}
