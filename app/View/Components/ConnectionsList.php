<?php

namespace App\View\Components;

use App\Models\Connection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConnectionsList extends Component
{
    /**
     * Create a new component instance.
     */
    public $connections;

    public function __construct()
    {
        $user = auth()->user();
    
        // Get all connections where the user is either the requester or addressee and status is 'accepted'
        $this->connections = Connection::where(function ($query) use ($user) {
                $query->where('requester_id', $user->id)
                      ->orWhere('addressee_id', $user->id);
            })
            ->where('status', 'accepted')  // Filter connections where status is 'accepted'
            ->with(['requester', 'addressee'])  // Eager load both requester and addressee users
            ->get()
            ->map(function ($connection) use ($user) {
                // Determine the other user (not the logged-in user)
                $otherUser = $connection->requester_id == $user->id
                    ? $connection->addressee
                    : $connection->requester;
    
                // Return both the connection and the other user
                return [
                    'connection' => $connection,
                    'user' => $otherUser
                ];
            });
    }    


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.connections-list');
    }
}
