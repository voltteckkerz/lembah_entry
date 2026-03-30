<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['employee'])
            ->orderBy('check_in_time', 'desc')
            ->get();

        $allEmployees = Employee::all();
        $totalEmployees = Employee::count();
        $presentCount = Attendance::whereDate('check_in_time', now()->toDateString())->whereNull('check_out_time')->distinct('employee_id')->count();

        return Inertia::render('Attendance/Index', [
            'attendances' => $attendances,
            'allStaff' => $allEmployees,
            'stats' => [
                'totalStaff' => $totalEmployees,
                'presentToday' => $presentCount,
            ]
        ]);
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'vehicle_plate' => 'nullable|string|max:20'
        ]);

        $employeeId = $validated['employee_id'];
        $employee = Employee::find($employeeId);

        // Check if already checked in today
        $existing = Attendance::where('employee_id', $employeeId)
            ->whereNull('check_out_time')
            ->first();

        if ($existing) {
            return back()->withErrors(['staff_name' => 'Staff is already checked in.']);
        }

        Attendance::create([
            'employee_id' => $employeeId,
            'vehicle_plate' => $validated['vehicle_plate'] ?? $employee->plate_number,
            'check_in_time' => now(),
            'user_id' => auth()->id()
        ]);

        return back();
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id'
        ]);

        $attendance = Attendance::where('employee_id', $validated['employee_id'])
            ->whereNull('check_out_time')
            ->orderBy('check_in_time', 'desc')
            ->first();

        if (!$attendance) {
            return back()->withErrors(['staff_id' => 'No active check-in found for this staff.']);
        }

        $attendance->update([
            'check_out_time' => now()
        ]);

        return back();
    }
}
