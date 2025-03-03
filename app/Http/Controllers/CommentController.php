<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $validated['content']
        ]);

        return response()->json([
            'success' => true,
            'message' => "comment added succisfully"
        ]);;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        dd($request,$comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
