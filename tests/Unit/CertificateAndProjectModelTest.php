<?php

use App\Models\Certificate;
use App\Models\Project;
use App\Models\User;

test('certificate casts date values and belongs to its owner', function () {
    $user = User::factory()->create();

    $certificate = Certificate::create([
        'title' => 'Laravel Basics',
        'provider' => 'Test Academy',
        'date' => '2026-07-08',
        'user_id' => $user->id,
    ]);

    $this->assertTrue($certificate->user->is($user));
    expect($certificate->date->toDateString())->toBe('2026-07-08');
});

test('project belongs to its owner', function () {
    $user = User::factory()->create();

    $project = Project::create([
        'title' => 'Profile builder',
        'description' => 'A project created for relation testing.',
        'demo_link' => 'https://example.com/demo',
        'code_link' => 'https://example.com/code',
        'user_id' => $user->id,
    ]);

    $this->assertTrue($project->user->is($user));
});