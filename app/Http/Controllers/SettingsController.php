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
        return view('settings.system_setting');
    }

    public function update_system_setting(Request $request)
    {
        $request->validate([
            'language' => 'required|in:id,en',
            'theme' => 'required|in:light,dark,system',
        ]);

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
}
