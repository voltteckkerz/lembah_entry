<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
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
            ],
        ]);
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'check_in_time' => 'nullable|string|max:10',
        ]);

        $employee = Employee::find($validated['employee_id']);

        // Check if already checked in (has an active session)
        $existing = Attendance::where('employee_id', $employee->employee_id)
            ->whereNull('check_out_time')
            ->first();

        if ($existing) {
            return back()->withErrors(['staff_name' => 'Staff is already checked in.']);
        }

        $checkInTime = now();
        if (!empty($validated['check_in_time'])) {
            try {
                $manualTime = Carbon::parse($validated['check_in_time']);
                $checkInTime = now()->setTime($manualTime->hour, $manualTime->minute, 0);
            } catch (\Exception $e) {
                $checkInTime = now();
            }
        }

        // Always use the employee's registered plate number — ignore form input
        Attendance::create([
            'employee_id' => $employee->employee_id,
            'vehicle_plate' => $employee->plate_number,
            'check_in_time' => $checkInTime,
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'check_out_time' => 'nullable|string|max:10',
        ]);

        $attendance = Attendance::where('employee_id', $validated['employee_id'])
            ->whereNull('check_out_time')
            ->orderBy('check_in_time', 'desc')
            ->first();

        if (!$attendance) {
            return back()->withErrors(['staff_id' => 'No active check-in found for this staff.']);
        }

        $checkOutTime = now();
        if (!empty($validated['check_out_time'])) {
            try {
                $manualTime = Carbon::parse($validated['check_out_time']);
                // Use the date from check_in_time but set the time from manual input
                $checkOutTime = Carbon::parse($attendance->check_in_time)
                    ->setTime($manualTime->hour, $manualTime->minute, 0);
            } catch (\Exception $e) {
                // If parsing fails, fall back to current time
                $checkOutTime = now();
            }
        }

        $attendance->update([
            'check_out_time' => $checkOutTime,
        ]);

        return back();
    }

    public function registerStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:employees,name',
            'plate_number' => 'nullable|string|max:25|unique:employees,plate_number',
        ], [
            'name.unique' => 'A staff member with this name is already registered.',
            'plate_number.unique' => 'This vehicle plate number is already registered to another staff member.',
        ]);

        Employee::create($validated);

        return back()->with('success', 'Staff member registered successfully.');
    }

    public function destroyStaff(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Staff member deleted.');
    }
}
