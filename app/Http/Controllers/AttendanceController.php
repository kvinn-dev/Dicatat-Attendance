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

        $existing = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already checked in today');
        }

        $startTime = Carbon::createFromTime(9, 0, 0);
        $status = $now->gt($startTime) ? 'late' : 'present';

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

    public function report(Request $request)
    {
        $query = Attendance::with('employee.user');

        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('attendances.report', compact('attendances'));
    }
}
