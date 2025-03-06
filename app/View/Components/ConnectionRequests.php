<?php

namespace App\View\Components;

use App\Models\Connection;
use Illuminate\View\Component;

class ConnectionRequests extends Component
{
    public $requests;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Get all pending connection requests where the logged-in user is the addressee
        $this->requests = Connection::where('addressee_id', auth()->id())
            ->where('status', 'pending')
            ->with('requester') // Eager load requester data
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.connection-requests');
    }
}
