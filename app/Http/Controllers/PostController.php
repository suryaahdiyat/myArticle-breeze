<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function myPost(Request $request){
        $posts = Post::where('user_id', auth()->user()->id)->paginate(8);

        return view('Post.index', [
            'posts' => $posts
        ]);
    }
    public function allPost(Request $request){
        $search = request('search');

        // start query
        $posts = Post::latest();

        $query = false;
        // Jika ada input search, tambahkan filter
        if ($search) {
            $posts = $posts->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
            $query = true;
        }

        // Lanjutkan dengan paginasi
        $posts = $posts->paginate(8);

        return view('allPost', [
            'posts' => $posts,
            'query' => $query
        ]);
    }
    public function dashboard(Request $request){
        return view('dashboard', [
            'posts' => Post::latest()->limit(6)->get()
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|file|max:1024',
            'content' => 'required', //content null
        ]);

        $image = null;
        if ($request->file('image')) $image = $request->file('image')->store('post-images', 'public');
        Post::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'image' => $image,
            'content' => $request->content,
        ]);
        return redirect('/myPost')->with('success', 'added new post successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $hasLiked = $post->likes()->where('user_id', auth()->id())->exists();
        $likesCount = $post->likes()->count();
        $commentCount = $post->comments()->count();
        $comments = $post->comments()->latest()->simplePaginate(5);
        // dd($comments);
        return view('Post.detail', [
            'post' => $post,
            'likesCount' => $likesCount,
            'commentCount' => $commentCount,
            'comments' => $comments,
            'hasLiked' => $hasLiked
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('Post.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|file|max:1024',
            'content' => 'required',
        ]);

        $image = null;
        if ($request->oldImage) {
            $image = $request->oldImage;
        }

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $image = $request->file('image')->store('post-images', 'public');
        }
        $post->update([
            'title' => $request->title,
            'image' => $image,
            'content' => $request->content,
        ]);

        return redirect('/myPost')->with('success', 'updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image) Storage::delete($post->image);
        $post->delete();

        return redirect('/myPost')->with('success', 'post deleted successfully!');
    }
}
