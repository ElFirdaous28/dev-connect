<?php

namespace App\View\Components;

use App\Models\User;
use App\Models\Connection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuggestedConnections extends Component
{
    /**
     * Create a new component instance.
     */
    public $users;
    public function __construct()
    {
        $this->users = User::where('id', '!=', auth()->id())
            ->inRandomOrder()
            ->take(10)
            ->select('id','name', 'profile_link', 'headline')
            ->get();

        foreach ($this->users as $user) {
            $status = Connection::getConnectionStatus($user->id, auth()->user()->id);
            $user->connectionStatus = $status;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.suggested-connections');
    }
}
