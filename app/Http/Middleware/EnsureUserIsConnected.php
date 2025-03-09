<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsConnected
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();
        $otherUser = User::find($request->user); // Get user from URL

        // If the user does not exist, redirect to connections list
        if (!$otherUser) {
            return redirect()->route('connections.list')->with('error', 'User not found.');
        }

        // Check if a connection exists between the authenticated user and the user in the URL
        $isConnected = Connection::where(function ($query) use ($authUser, $otherUser) {
            $query->where('requester_id', $authUser->id)
                ->where('addressee_id', $otherUser->id);
        })
            ->orWhere(function ($query) use ($authUser, $otherUser) {
                $query->where('requester_id', $otherUser->id)
                    ->where('addressee_id', $authUser->id);
            })
            ->where('status', 'accepted') // Ensure the connection is accepted
            ->exists();

        // If no connection exists, redirect the user
        if (!$isConnected) {
            return redirect()->route('connections.list')->with('error', 'You are not connected with this user.');
        }

        return $next($request);
    }
}
