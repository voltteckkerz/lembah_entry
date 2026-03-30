<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Visit;
use App\Models\Visitor;
use App\Models\Vehicle;
use App\Models\Item;
use Illuminate\Support\Str;

class VisitController extends Controller
{
    // Disabled: Visitor Logs migrated to History UI
    public function index()
    {
        return redirect()->route('history.index');
    }

    public function create()
    {
        $employees = Employee::all();
        
        $todayVisits = Visit::with(['visitors', 'employee', 'vehicles'])
            ->whereDate('visit_date', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Visit/Create', [
            'employees' => $employees,
            'todayVisits' => $todayVisits
        ]);
    }

    public function showPass(Visit $visit)
    {
        $visit->load(['visitors', 'employee', 'vehicles', 'items']);
        return Inertia::render('Visit/Pass', [
            'visit' => $visit
        ]);
    }

    public function sign(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'role' => 'required|in:guard,visitor,host,supervisor',
            'signature' => 'required|string', // base64 string
        ]);

        $column = $validated['role'] . '_signature';
        $visit->update([$column => $validated['signature']]);

        // Sequential Workflow Logic
        if ($validated['role'] === 'host') {
            // Ping Supervisor
            \App\Models\Notification::create([
                'user_id' => 1, // Assuming Supervisor is Admin (user_id 1)
                'visit_id' => $visit->visit_id,
                'message' => 'Pass ' . $visit->pass_number . ' verified by Host. Awaiting Duty Supervisor clearance.',
                'status' => 'unread'
            ]);
        } elseif ($validated['role'] === 'supervisor') {
            // Final Approval achieved
            $visit->update(['status' => 'Approved']);
        }

        // Final Redirect
        if (in_array($validated['role'], ['host', 'supervisor'])) {
            return redirect()->route('approvals.index')->with('success', 'Signature secured. Pass routed to next stage.');
        }

        return redirect()->back()->with('success', 'Signature saved successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purpose' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,employee_id',
            'visitors' => 'required|array|min:1|max:5',
            'visitors.*.name' => 'required|string|max:100',
            'visitors.*.ic_number' => 'required|string|max:20',
            'vehicle_plate' => 'nullable|string|max:20',
            'vehicle_type' => 'nullable|string|max:50',
            'items' => 'nullable|array',
            'guard_signature' => 'required|string',
            'visitor_signature' => 'required|string',
        ]);

        // Generate a pass number
        $passNumber = 'VP-' . strtoupper(Str::random(6));

        $visit = Visit::create([
            'employee_id' => $validated['employee_id'],
            'user_id' => auth()->id(),
            'pass_number' => $passNumber,
            'visit_date' => now()->toDateString(),
            'purpose' => $validated['purpose'],
            'status' => 'Pending',
            'guard_signature' => $validated['guard_signature'],
            'visitor_signature' => $validated['visitor_signature'],
        ]);

        foreach ($validated['visitors'] as $visitorData) {
            $visitor = Visitor::create([
                'name' => $visitorData['name'],
                'ic_number' => $visitorData['ic_number'],
            ]);
            $visit->visitors()->attach($visitor->visitor_id);
        }

        if (!empty($validated['vehicle_plate'])) {
            Vehicle::create([
                'plate_number' => $validated['vehicle_plate'],
                'vehicle_type' => $validated['vehicle_type'],
                'owner_type' => 'visitor',
                'visit_id' => $visit->visit_id,
            ]);
        }

        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $itemData) {
                if (!empty($itemData['item_name'])) {
                    Item::create([
                        'visit_id' => $visit->visit_id,
                        'item_name' => $itemData['item_name'],
                        'quantity' => $itemData['quantity'] ?? 1,
                        'remarks' => $itemData['remarks'] ?? '',
                    ]);
                }
            }
        }
        
        // Notify Host (Systematically sending to User 1 for demo bounds, or dynamic if Users map to Employees)
        \App\Models\Notification::create([
            'user_id' => 1,
            'visit_id' => $visit->visit_id,
            'message' => 'New visitor registration requires Host verification signature.',
            'status' => 'unread'
        ]);

        return redirect()->route('visits.create')->with('success', 'Visit registered and signatures captured.');
    }
}
