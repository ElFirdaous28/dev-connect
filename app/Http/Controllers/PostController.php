<?php

namespace App\Http\Controllers;

use App\Jobs\AutoPublishPost;
use App\Models\Hashtag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function dashboard()
    {
        $posts = Post::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(3);

        return view('dashboard', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Create a collection of objects (simulating your hashtags data)
        $hashtagsCollection = collect([
            (object) ['id' => 14, 'name' => 'hello'],
            (object) ['id' => 15, 'name' => 'world'],
            (object) ['id' => 16, 'name' => 'mytag']
        ]);

        $posts = Post::where('user_id', auth()->id())->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hashtags' => 'required',
            'publish_time' => 'nullable|date',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'publish_time' => $validated['publish_time'] ?? null,
            'status' => $validated['publish_time'] ? 'draft' : 'published',
        ]);

        // Handle hashtags
        $tagsArray = array_filter(preg_split('/[\s#]+/', $request->hashtags));
        $hashtagsIds = [];
        foreach ($tagsArray as $tagName) {
            $tag = Hashtag::firstOrCreate(['name' => $tagName]);
            $hashtagsIds[] = $tag->id;
        }
        $post->hashtags()->sync($hashtagsIds);

        // Handle image upload
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts_images', 'public');
            $post->save();
        }

        // Schedule the post if publish_time is set
        if ($request->publish_time) {
            AutoPublishPost::dispatch($post)
                ->delay(now()->parse($request->publish_time));
        } else {
            $post->update(['status' => 'published']);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Ensure only the owner can update the post
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hashtags' => 'required',
        ]);

        // Update post fields
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->save();

        // hashtags
        $tagsArray = array_filter(preg_split('/[\s#]+/', $request->hashtags));

        $hashtagsIds = [];
        foreach ($tagsArray as $tagName) {
            $tag = Hashtag::firstOrCreate(['name' => $tagName]);
            $hashtagsIds[] = $tag->id;
        }

        $post->hashtags()->sync($hashtagsIds);

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Store new image
            $post->image = $request->file('image')->store('posts_images', 'public');
            $post->save();
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back();
    }
}
