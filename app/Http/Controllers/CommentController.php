<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $validated['content']
        ]);

        $post->user->notify(new CommentNotification($comment));

        return response()->json([
            'success' => true,
            'message' => "Comment added successfully",
            'comment' => $comment
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);
        return response()->json([
            'success'=>true,
            'message' => "comment edited succisfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => "Comment deleted successfully"
        ]);
    }    
}
