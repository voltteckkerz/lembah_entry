<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function staffAttendance(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $attendances = Attendance::with('employee')
            ->whereDate('check_in_time', $date)
            ->get();

        return Inertia::render('Reports/StaffAttendance', [
            'attendances' => $attendances,
            'date' => $date,
        ]);
    }

    public function visitorAttendance(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        // Flatten visits so each visitor is a separate row
        $visits = Visit::with(['visitors', 'employee', 'vehicles'])
            ->whereDate('visit_date', $date)
            ->get();

        $rows = [];
        foreach ($visits as $visit) {
            foreach ($visit->visitors as $visitor) {
                $rows[] = [
                    'name' => $visitor->name,
                    'company' => $visitor->company ?? '-',
                    'vehicle' => $visit->vehicles->first()->plate_number ?? '-',
                    'date' => $visit->visit_date,
                    'time_in' => $visit->check_in_time,
                    'time_out' => $visit->check_out_time,
                    'pass' => $visit->pass_number,
                ];
            }
        }

        return Inertia::render('Reports/VisitorAttendance', [
            'rows' => $rows,
            'date' => $date,
        ]);
    }
}
