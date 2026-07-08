<?php

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

test('comment belongs to the correct user and post', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Comment source',
        'content' => 'Used for relation testing.',
        'user_id' => $user->id,
    ]);

    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'A useful note',
    ]);

    $this->assertTrue($comment->user->is($user));
    $this->assertTrue($comment->post->is($post));
});

test('like belongs to the correct user and post', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Like source',
        'content' => 'Used for like relation testing.',
        'user_id' => $user->id,
    ]);

    $like = Like::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $this->assertTrue($like->user->is($user));
    $this->assertTrue($like->post->is($post));
});