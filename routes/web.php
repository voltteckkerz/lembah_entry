<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $today = now()->toDateString();
    
    $totalVisitorsToday = \App\Models\Visit::whereDate('visit_date', $today)->count();
    $activeVisitors = \App\Models\Visit::where('status', 'Active')->count();
    $staffPresent = \App\Models\Attendance::whereDate('check_in_time', $today)
        ->whereNull('check_out_time')
        ->distinct('staff_id')
        ->count();

    $recentVisits = \App\Models\Visit::with(['visitors', 'employee'])
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

    return Inertia::render('Dashboard', [
        'stats' => [
            'totalVisitorsToday' => $totalVisitorsToday,
            'activeVisitors' => $activeVisitors,
            'staffPresent' => $staffPresent,
        ],
        'recentVisits' => $recentVisits,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('visits', \App\Http\Controllers\VisitController::class);
    
    // Approvals
    Route::get('/approvals', [\App\Http\Controllers\ApprovalController::class, 'index'])->name('approvals.index');
    Route::patch('/approvals/{visit}', [\App\Http\Controllers\ApprovalController::class, 'update'])->name('approvals.update');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Attendance
    Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [\App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [\App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // History Archive
    Route::get('/history', [\App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');

    // Visitor Access Actions
    Route::get('/visits/{visit}/pass', [\App\Http\Controllers\VisitController::class, 'showPass'])->name('visits.pass');
    Route::patch('/visits/{visit}/sign', [\App\Http\Controllers\VisitController::class, 'sign'])->name('visits.sign');
    Route::patch('/visits/{visit}/check-in', function(\App\Models\Visit $visit) {
        if ($visit->status === 'Approved') {
            $visit->update(['status' => 'Active', 'check_in_time' => now()]);
        }
        return back();
    })->name('visits.checkin');

    Route::patch('/visits/{visit}/check-out', function(\App\Models\Visit $visit) {
        if ($visit->status === 'Active') {
            $visit->update(['status' => 'Checked Out', 'check_out_time' => now()]);
        }
        return back();
    })->name('visits.checkout');
});

require __DIR__.'/auth.php';

// Prototype Routes - For viewing raw UI components
Route::prefix('prototype')->group(function () {
    Route::get('/login', function () { return \Inertia\Inertia::render('Prototype/Login'); });
    Route::get('/dashboard', function () { return \Inertia\Inertia::render('Prototype/Dashboard'); });
    Route::get('/register', function () { return \Inertia\Inertia::render('Prototype/RegisterVisit'); });
    Route::get('/notifications', function () { return \Inertia\Inertia::render('Prototype/Notifications'); });
    Route::get('/approval', function () { return \Inertia\Inertia::render('Prototype/Approval'); });
    Route::get('/history', function () { return \Inertia\Inertia::render('Prototype/History'); });
    Route::get('/attendance', function () { return \Inertia\Inertia::render('Prototype/Attendance'); });
});
