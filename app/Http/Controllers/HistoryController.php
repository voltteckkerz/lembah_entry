<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        // Get all historical visits (descending order)
        $visits = Visit::with(['visitors', 'employee', 'vehicles'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all historical attendances
        $attendances = Attendance::with(['employee'])
            ->orderBy('check_in_time', 'desc')
            ->get();

        return Inertia::render('History/Index', [
            'visits' => $visits,
            'attendances' => $attendances
        ]);
    }
}
