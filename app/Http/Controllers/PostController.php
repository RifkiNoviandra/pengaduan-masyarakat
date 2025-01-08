<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderByDesc('id')->paginate(10);
        return view('pages.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('pages.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post = Post::create($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Postingan berhasil dibuat!');
    }

    public function show(Post $post)
    {
        return view('pages.posts.post', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('pages.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Postingan berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Postingan berhasil dihapus.');
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $post->comments()->create([
            'user_name' => Auth::user()->name,
            'comment' => $request->comment,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function addReaction(Request $request, Comment $comment)
    {
        $request->validate([
            'reaction' => 'required|string|max:2',
        ]);

        $comment->reactions()->create([
            'reaction' => $request->reaction,
        ]);

        return redirect()->back()->with('success', 'Reaksi berhasil ditambahkan!');
    }
}
