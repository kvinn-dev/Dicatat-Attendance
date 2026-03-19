<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_employees' => User::where('role', 'employee')->count(),
            'present_today' => Attendance::where('date', $today)->where('status', '!=', 'absent')->count(),
            'late_today' => Attendance::where('date', $today)->where('status', 'late')->count(),

            'absent_today' => Attendance::where('date', $today)->where('status', 'absent')->count(),
        ];

        $recent_attendances = Attendance::with('employee.user')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        $workDaysStr = \App\Models\Setting::get('work_days', '["1","2","3","4","5"]');
        $workDays = json_decode($workDaysStr, true) ?? ["1","2","3","4","5"];
        $currentDay = (string) $today->dayOfWeek; // 0 = Minggu, 1 = Senin, dst.
        $is_work_day = in_array($currentDay, $workDays);

        return view('dashboard', compact('stats', 'recent_attendances', 'is_work_day'));
    }
}
