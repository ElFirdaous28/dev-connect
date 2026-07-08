<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('user posts relation returns authored posts', function () {
    $user = User::factory()->create();

    $post = Post::create([
        'title' => 'First post',
        'content' => 'This is a test post.',
        'user_id' => $user->id,
    ]);

    expect($user->posts)->toHaveCount(1);
    $this->assertTrue($user->posts->first()->is($post));
});

test('user comments relation returns authored comments', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'A post to comment on',
        'content' => 'Comment target',
        'user_id' => $user->id,
    ]);

    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Helpful feedback',
    ]);

    expect($user->comments)->toHaveCount(1);
    $this->assertTrue($user->comments->first()->is($comment));
});