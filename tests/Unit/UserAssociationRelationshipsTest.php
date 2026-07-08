<?php

use App\Models\ProgrammingLanguage;
use App\Models\Skill;
use App\Models\User;

test('user skills relation returns attached skills', function () {
    $user = User::factory()->create();
    $skill = Skill::forceCreate(['name' => 'Laravel']);

    $user->skills()->attach($skill->id);

    expect($user->skills)->toHaveCount(1);
    $this->assertTrue($user->skills->first()->is($skill));
});

test('user programming languages relation returns attached languages', function () {
    $user = User::factory()->create();
    $language = ProgrammingLanguage::forceCreate(['name' => 'PHP']);

    $user->programmingLanguages()->attach($language->id);

    expect($user->programmingLanguages)->toHaveCount(1);
    $this->assertTrue($user->programmingLanguages->first()->is($language));
});