<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the attendance report for the logged-in user.
     */
    public function index()
    {
        // Get the currently authenticated user ID
        $employeeId = Auth::user()->employee->id;

        // 1. Fetch Statistics
        $stats = [
            'total_attendance' => Attendance::where('employee_id', $employeeId)->count(),
            'total_present'    => Attendance::where('employee_id', $employeeId)->where('status', 'present')->count(),
            'total_late'       => Attendance::where('employee_id', $employeeId)->where('status', 'late')->count(),
            'total_absent'     => Attendance::where('employee_id', $employeeId)->where('status', 'absent')->count(),
            'total_leave'      => Attendance::where('employee_id', $employeeId)->where('status', 'leave')->count(),
        ];

        // 2. Fetch Monthly Progress Data (Current Year)
        // Group by month and count attendances
        $monthlyData = Attendance::where('employee_id', $employeeId)
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 3. Prepare Data for Chart.js
        // Initialize arrays for labels and data
        $labels = [];
        $data = [];
        
        // Create a map of month number => count (default 0 for all 12 months)
        $counts = array_fill(1, 12, 0);

        // Fill in the actual data from the database
        foreach ($monthlyData as $row) {
            $counts[$row->month] = $row->count;
        }

        // Convert to Chart.js format (Labels: "January", Data: 5)
        foreach ($counts as $monthNum => $count) {
            $labels[] = Carbon::create()->month($monthNum)->format('F');
            $data[] = $count;
        }

        return view('reports.index', compact('stats', 'labels', 'data'));
    }
}
