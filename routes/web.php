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
})->name('welcome');

Route::get('/dashboard', function () {
    $today = now()->toDateString();
    $startOfMonth = now()->startOfMonth()->toDateString();
    $endOfMonth = now()->endOfMonth()->toDateString();

    $totalVisitorsToday = \App\Models\Visit::whereDate('visit_date', $today)->count();
    $activeVisitors = \App\Models\Visit::where('status', 'Active')->count();
    $staffPresent = \App\Models\Attendance::whereDate('check_in_time', $today)
        ->whereNull('check_out_time')
        ->distinct('employee_id')
        ->count();

    $recentVisits = \App\Models\Visit::with(['visitors', 'employee'])
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

    $calendarVisits = \App\Models\Visit::with(['visitors', 'employee'])
        ->whereBetween('visit_date', [$startOfMonth, $endOfMonth])
        ->get();

    return Inertia::render('Dashboard', [
        'stats' => [
            'totalVisitorsToday' => $totalVisitorsToday,
            'activeVisitors' => $activeVisitors,
            'staffPresent' => $staffPresent,
        ],
        'recentVisits' => $recentVisits,
        'calendarVisits' => $calendarVisits,
        'supportRequests' => auth()->user()->role === 'Admin'
            ? \App\Models\SupportRequest::where('status', 'Pending')->get()
            : [],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Support Requests (Guard Password Reset)
Route::post('/support/password-reset', [\App\Http\Controllers\SupportRequestController::class, 'store'])->name('support.password_reset');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('visits', \App\Http\Controllers\VisitController::class);


    // User Administration
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.reset-password');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Attendance
    Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [\App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [\App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::post('/attendance/register-staff', [\App\Http\Controllers\AttendanceController::class, 'registerStaff'])->name('attendance.register-staff');
    Route::delete('/attendance/staff/{employee}', [\App\Http\Controllers\AttendanceController::class, 'destroyStaff'])->name('attendance.destroy-staff');

    Route::delete('/visitors/{visitor}', function(\App\Models\Visitor $visitor) {
        $visitor->delete();
        return back();
    })->name('visitors.destroy');


    // History Archive
    Route::get('/history', [\App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');

    // Visitor Access Actions
    Route::get('/visits/{visit}/pass', [\App\Http\Controllers\VisitController::class, 'showPass'])->name('visits.pass');
    Route::patch('/visits/{visit}/sign', [\App\Http\Controllers\VisitController::class, 'sign'])->name('visits.sign');
    Route::patch('/visits/{visit}/check-in', function(\App\Models\Visit $visit, \Illuminate\Http\Request $request) {
        if ($visit->status === 'Approved') {
            $checkInTime = now();
            if (!empty($request->check_in_time)) {
                try {
                    $m = \Carbon\Carbon::parse($request->check_in_time);
                    $checkInTime = now()->setTime($m->hour, $m->minute, 0);
                } catch(\Exception $e) {}
            }
            $visit->update(['status' => 'Active', 'check_in_time' => $checkInTime]);
        }
        return back();
    })->name('visits.checkin');

    Route::patch('/visits/{visit}/check-out', function(\App\Models\Visit $visit, \Illuminate\Http\Request $request) {
        if ($visit->status === 'Active') {
            $checkOutTime = now();
            if (!empty($request->check_out_time)) {
                try {
                    $m = \Carbon\Carbon::parse($request->check_out_time);
                    $checkOutTime = \Carbon\Carbon::parse($visit->check_in_time)->setTime($m->hour, $m->minute, 0);
                } catch (\Exception $e) {}
            }
            $visit->update(['status' => 'Checked Out', 'check_out_time' => $checkOutTime]);
        }
        return back();
    })->name('visits.checkout');

    // Reports
    Route::get('/reports/staff-attendance', [\App\Http\Controllers\ReportController::class, 'staffAttendance'])->name('reports.staff');
    Route::get('/reports/visitor-attendance', [\App\Http\Controllers\ReportController::class, 'visitorAttendance'])->name('reports.visitor');

    // Resolve Support Requests
    Route::patch('/support/resolve/{supportRequest}', [\App\Http\Controllers\SupportRequestController::class, 'resolve'])->name('support.resolve');
    // Support Chat
    Route::get('/chat/unread', [\App\Http\Controllers\ChatController::class, 'checkUnread'])->name('chat.unread');
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
});

require __DIR__.'/auth.php';

