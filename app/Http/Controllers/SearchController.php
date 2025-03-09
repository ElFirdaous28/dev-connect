<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $value = $request->value;

        // Search posts by title
        $posts = Post::where('title', 'like', "%{$value}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Search users by name
        $users = User::where('name', 'like', "%{$value}%")
            ->orderBy('name')
            ->paginate(10);

        return view('search', compact('posts', 'users', 'value'));
    }
}
