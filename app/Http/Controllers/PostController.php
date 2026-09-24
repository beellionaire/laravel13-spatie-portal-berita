<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Pest\Plugins\Only;

class PostController extends Controller
{
    public function index()
    {
       Gate::authorize('viewAny', Post::class);
       $posts = Post::with('user')->latest()->get();
       return view('posts.index', compact('posts'));
    }

    public function create() {
        Gate::authorize('create', Post::class);
        return view('posts.create');
    }

    public function store(Request $request) {
        Gate::authorize('create', Post::class);

        // validation form 
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Auth::user()->posts()->create($request->only(['title','content']));

        return redirect()->route('posts.index');
    }

    public function edit(Post $post) {
        Gate::authorize('update', $post);

        return view('posts.edit', compact('post'));

    }

    public function update(Request $request, Post $post) {
        Gate::authorize('update', $post);

        // validation form
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($request->only(['title', 'content']));

        return redirect()->route('posts.index');

    }

    public function destroy(Post $post) {
        Gate::authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
