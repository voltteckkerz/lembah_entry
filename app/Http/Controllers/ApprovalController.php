<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApprovalController extends Controller
{
    public function index()
    {
        $query = Visit::with(['employee', 'visitors', 'vehicles', 'user'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'asc');

        $user = auth()->user();

        // Host constraints: only see passes assigned to their Employee name, AND where they haven't signed yet
        if ($user && $user->role === 'host') {
            $employee = \App\Models\Employee::where('name', $user->name)->first();
            if ($employee) {
                $query->where('employee_id', $employee->employee_id);
            } else {
                $query->where('employee_id', -1); // Failsafe empty
            }
            $query->whereNull('host_signature');
        }

        // Supervisor constraints: only see passes where the Host has ALREADY signed
        if ($user && $user->role === 'supervisor') {
            $query->whereNotNull('host_signature');
        }

        $pendingVisits = $query->get();

        return Inertia::render('Visit/Approval', [
            'pendingVisits' => $pendingVisits
        ]);
    }

    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected'
        ]);

        $visit->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()->with('success', 'Visit status updated successfully.');
    }
}
