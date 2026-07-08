<?php

use App\Models\Hashtag;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

test('post belongs to its author', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Author check',
        'content' => 'Verifies the user relation.',
        'user_id' => $user->id,
    ]);

    $this->assertTrue($post->user->is($user));
});

test('post exposes its comments likes and hashtags relations', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Engagement check',
        'content' => 'Verifies core engagement relations.',
        'user_id' => $user->id,
    ]);

    $post->comments()->create([
        'user_id' => $user->id,
        'content' => 'Nice post',
    ]);

    Like::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $hashtag = Hashtag::create(['name' => 'testing']);
    $post->hashtags()->attach($hashtag->id);

    expect($post->comments)->toHaveCount(1);
    expect($post->likes)->toHaveCount(1);
    expect($post->hashtags)->toHaveCount(1);
});