<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * Display the chat interface and load relevant messages based on role.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role === 'Admin') {
            // All admins act as a shared inbox
            $adminIds = User::where('role', 'Admin')->pluck('user_id');

            // Admin sees a list of guards to select from.
            $guards = User::where('role', 'guard')->get();
            $activeGuardId = $request->input('guard_id', $guards->first()?->user_id);
            
            $messages = [];
            if ($activeGuardId) {
                $messages = Message::with(['sender', 'receiver'])
                    ->where(function($query) use ($activeGuardId, $adminIds) {
                        $query->whereIn('sender_id', $adminIds)
                              ->where('receiver_id', $activeGuardId);
                    })->orWhere(function($query) use ($activeGuardId, $adminIds) {
                        $query->where('sender_id', $activeGuardId)
                              ->whereIn('receiver_id', $adminIds);
                    })->orderBy('created_at', 'asc')->get();
                
                // Mark messages sent to the Admin from this guard as read
                Message::where('sender_id', $activeGuardId)
                       ->whereIn('receiver_id', $adminIds)
                       ->where('is_read', false)
                       ->update(['is_read' => true]);
            }

            // Let's get unread counts for each guard for the admin
            $unreadCounts = Message::whereIn('receiver_id', $adminIds)
                                   ->where('is_read', false)
                                   ->selectRaw('sender_id, count(*) as count')
                                   ->groupBy('sender_id')
                                   ->pluck('count', 'sender_id');

            return Inertia::render('Chat/Index', [
                'role' => 'Admin',
                'guards' => $guards->map(function ($guard) use ($unreadCounts) {
                    $guard->unread_count = $unreadCounts[$guard->user_id] ?? 0;
                    return $guard;
                }),
                'activeGuardId' => (int) $activeGuardId,
                'messages' => $messages,
            ]);

        } else {
            // Guard role: only chats with the principal Admin (Shared Inbox)
            $adminIds = User::where('role', 'Admin')->pluck('user_id');
            // Provide a primary admin as default receiver
            $primaryAdmin = User::where('role', 'Admin')->first();
            
            if (!$primaryAdmin) abort(404, 'Admin not found');

            $messages = Message::with(['sender', 'receiver'])
                ->where(function($query) use ($user, $adminIds) {
                    $query->where('sender_id', $user->user_id)
                          ->whereIn('receiver_id', $adminIds);
                })->orWhere(function($query) use ($user, $adminIds) {
                    $query->whereIn('sender_id', $adminIds)
                          ->where('receiver_id', $user->user_id);
                })->orderBy('created_at', 'asc')->get();

            // Mark Admin's messages to this guard as read
            Message::whereIn('sender_id', $adminIds)
                   ->where('receiver_id', $user->user_id)
                   ->where('is_read', false)
                   ->update(['is_read' => true]);

            return Inertia::render('Chat/Index', [
                'role' => 'guard',
                'adminId' => $primaryAdmin->user_id,
                'messages' => $messages,
            ]);
        }
    }

    /**
     * Store a new message in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'content' => 'required|string|max:2000',
        ]);

        Message::create([
            'sender_id' => auth()->user()->user_id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        // Redirect back will trigger Inertia to reload the props (which natively updates the UI!)
        return back();
    }

    /**
     * API Endpoint to fetch global unread state for layouts.
     */
    public function checkUnread(Request $request)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['count' => 0, 'latest' => null]);

        $query = Message::where('is_read', false);

        if ($user->role === 'Admin') {
            $adminIds = User::where('role', 'Admin')->pluck('user_id');
            $query->whereIn('receiver_id', $adminIds);
        } else {
            $query->where('receiver_id', $user->user_id);
        }

        $count = $query->count();
        $latest = $query->with('sender')->orderBy('created_at', 'desc')->first();

        return response()->json([
            'count' => $count,
            'latest' => $latest ? [
                'id' => $latest->message_id,
                'sender' => $latest->sender->name ?? 'System',
                'content' => $latest->content
            ] : null,
        ]);
    }
}
