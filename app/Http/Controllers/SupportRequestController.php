<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;

class SupportRequestController extends Controller
{
    /**
     * Store a new support request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        SupportRequest::create([
            'username' => $request->username,
            'type' => 'Password Reset',
            'status' => 'Pending',
        ]);

        return back()->with('status', 'Your request has been sent to the Admin. Please wait for assistance.');
    }

    /**
     * Mark a support request as resolved.
     */
    public function resolve(SupportRequest $supportRequest)
    {
        $supportRequest->update(['status' => 'Resolved']);

        return back();
    }
}
