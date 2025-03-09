<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Notifications\LikeNotification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $like = $post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $isLiked = true;
            $post->user->notify(new LikeNotification($like));

        }

        return response()->json([
            'success' => true,
            'likesCount' => $post->likes()->count(),
            'isLiked' => $isLiked
        ]);
    }

    public function checkLike(Post $post)
    {
        return response()->json([
            'isLiked' => $post->likes()->where('user_id', auth()->id())->exists()
        ]);
    }
}
