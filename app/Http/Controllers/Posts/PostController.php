<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view posts.');
        }
        $is_mine = $request->query('mine', false);
        if ($is_mine) {
            $posts = Post::with('category', 'user')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
            return view('posts.index', compact('posts'));
        }
        $posts = Post::with('category', 'user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view posts.');
        }
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return redirect()->route('posts.index')->with('error', 'You must create a category before creating a post.');
        }
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a post.');
        }

        $validated = $request->validated();
        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->category_id = $validated['category_id'];
        $post->user_id = $user->id;
        $tagNames = $validated['tags'] ?? [];

        $tagIds = collect($tagNames)->map(function ($tagName) {
            $normalized = trim(Str::lower($tagName));

            return Tag::firstOrCreate(
                ['name' => $normalized],
            )->id;
        });


        $post->save();
        $post->tags()->sync($tagIds);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view posts.');
        }
        if ((int)$user->id !== (int)Post::find($id)->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this post.');
        }
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update a post.');
        }

        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }

        if ((int)$user->id !== (int)$post->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this post.');
        }

        $validated = $request->validated();

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->category_id = $validated['category_id'];
        $tagNames = $validated['tags'] ?? [];
        Log::info('Tag names: ' . implode(', ', $tagNames));
        $tagIds = collect($tagNames)->map(function ($tagName) {
            $normalized = trim(Str::lower($tagName));

            return Tag::firstOrCreate(
                ['name' => $normalized],
            )->id;
        });
        $post->updated_at = now(); // Update the timestamp


        $post->save();
        $post->tags()->sync($tagIds);
        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view posts.');
        }
        if ((int)$user->id !== (int)Post::find($id)->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to delete this post.');
        }
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
