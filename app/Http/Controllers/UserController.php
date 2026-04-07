<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Models\SupportRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the guard users.
     */
    public function index()
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        // We focus on fetching guards since Admin's primary user administration is for guards.
        $users = User::where('role', 'guard')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Update the specified user's password.
     */
    public function resetPassword(Request $request, User $user)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Resolve any open support requests related to this guard's login issues
        SupportRequest::where('username', $user->username)
            ->where('type', 'Password Reset') // Ensure we resolve the correct type if it exists
            ->where('status', 'Pending')
            ->update(['status' => 'Resolved']);

        return back()->with('success', 'Password reset successfully.');
    }
}
