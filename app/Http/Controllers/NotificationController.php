<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['visit', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Notification/Index', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        $notification->update(['status' => 'Read']);

        // Redirect back, or just return JSON if it were an API call
        return redirect()->back();
    }
}
