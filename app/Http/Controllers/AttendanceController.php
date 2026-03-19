<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn()
    {
        $user = Auth::user();

        if (!$user->employee) {
            return back()->with('error', 'Employee profile not found. Contact admin.');
        }

        $employee = $user->employee;
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // Pengecekan status hari kerja
        $workDaysStr = \App\Models\Setting::get('work_days', '["1","2","3","4","5"]');
        $workDays = json_decode($workDaysStr, true) ?? ["1","2","3","4","5"];
        if (!in_array((string) $now->dayOfWeek, $workDays)) {
            return back()->with('error', 'Hari ini bukan hari kerja. Tidak dapat melakukan Check In.');
        }

        $existing = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already checked in today');
        }

        $startTimeStr = \App\Models\Setting::get('work_start_time', '09:00');
        $startTime = Carbon::parse($startTimeStr);
        
        // Status telat jika jam check-in lebih dari 1 jam dari jadwal masuk
        $status = $now->gt($startTime->copy()->addHour()) ? 'late' : 'present';

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today,
            'check_in' => $now->toTimeString(),
            'status' => $status,
        ]);

        return back()->with('success', 'Checked in successfully.');
    }

    public function checkOut()
    {
        $user = Auth::user();
        if (!$user || !$user->employee) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu.');
        }

        $employee = $user->employee;
        $today = Carbon::today()->toDateString();

        // Pengecekan status hari kerja saat checkout (opsional, sebagai pengamanan API)
        $workDaysStr = \App\Models\Setting::get('work_days', '["1","2","3","4","5"]');
        $workDays = json_decode($workDaysStr, true) ?? ["1","2","3","4","5"];
        if (!in_array((string) Carbon::now()->dayOfWeek, $workDays)) {
            return back()->with('error', 'Hari ini bukan hari kerja. Tidak dapat melakukan Check Out.');
        }

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'You have not checked in yet');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'You have already checked out today');
        }

        $attendance->update([
            'check_out' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Checked out successfully.');
    }

    public function index(Request $request)
    {
        $query = Attendance::with('employee.user');

        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('attendances.index', compact('attendances'));
    }
}
