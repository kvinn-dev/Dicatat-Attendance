<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user memiliki data employee
        if (!$user->employee) {
            return redirect()->route('dashboard')->with('error', 'Data karyawan tidak ditemukan.');
        }

        $leaves = Leave::where('employee_id', $user->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leave.index', compact('leaves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        $user = Auth::user();

        Leave::create([
            'employee_id' => $user->employee->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }
}
