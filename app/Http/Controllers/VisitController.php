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
        $visitors = Visitor::all();

        $todayVisits = Visit::with(['visitors', 'employee', 'vehicles', 'items'])
            ->whereDate('visit_date', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Visit/Create', [
            'employees' => $employees,
            'todayVisits' => $todayVisits,
            'allVisitors' => $visitors
        ]);
    }

    public function showPass(Visit $visit)
    {
        $visit->load(['visitors', 'employee', 'vehicles', 'items']);
        return Inertia::render('Visit/Pass', [
            'visit' => $visit
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pass_number' => 'required|string|max:50',
            'purpose' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,employee_id',
            'visitors' => 'required|array|min:1|max:5',
            'visitors.*.name' => 'required|string|max:100',
            'visitors.*.ic_number' => 'required|string|max:20',
            'visitors.*.company' => 'nullable|string|max:100',
            'vehicle_plate' => 'nullable|string|max:20',
            'vehicle_type' => 'nullable|string|max:50',
            'items' => 'nullable|array',
            'items.*.item_name' => 'nullable|string|max:100',
            'items.*.quantity' => 'nullable|integer',
            'items.*.remarks' => 'nullable|string|max:255',
            'check_in_time' => 'nullable|string|max:10',
        ]);

        $checkInTime = now();
        if (! empty($validated['check_in_time'])) {
            try {
                $manualTime = \Carbon\Carbon::parse($validated['check_in_time']);
                $checkInTime = now()->setTime($manualTime->hour, $manualTime->minute, 0);
            } catch (\Exception $e) {}
        }

        $visit = Visit::create([
            'employee_id' => $validated['employee_id'],
            'user_id' => auth()->id(),
            'pass_number' => $validated['pass_number'],
            'visit_date' => now()->toDateString(),
            'check_in_time' => $checkInTime,
            'purpose' => $validated['purpose'],
            'status' => 'Active',
        ]);

        foreach ($validated['visitors'] as $visitorData) {
            // Find or update visitor by IC number
            $visitor = Visitor::updateOrCreate(
                ['ic_number' => $visitorData['ic_number']],
                [
                    'name' => $visitorData['name'],
                    'company' => $visitorData['company'] ?? '',
                ]
            );
            $visit->visitors()->attach($visitor->visitor_id);
        }

        if (!empty($validated['vehicle_plate'])) {
            Vehicle::create([
                'plate_number' => $validated['vehicle_plate'],
                'vehicle_type' => $validated['vehicle_type'] ?? 'Visitor',
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

        return redirect()->route('visits.create')->with('success', 'Visit registered and ready for check-in.');
    }
}
