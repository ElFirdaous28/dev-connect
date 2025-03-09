<?php

namespace App\View\Components;

use App\Models\JobRecommendation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JobRecommendations extends Component
{
    // Property to hold recommended jobs
    public $recommendedJobs;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->recommendedJobs = JobRecommendation::inRandomOrder()->limit(2)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.job-recommendations', [
            'recommendedJobs' => $this->recommendedJobs,  // Pass the recommended jobs to the view
        ]);
    }
}
