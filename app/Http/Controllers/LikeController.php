<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Request $request)
    {
        $user = auth()->user();
        $post = Post::findOrFail($request->post_id);

        // return response()->json([
        //     'user' => $user,
        //     'post' => $post
        // ]);


        if ($user->likedPosts()->where('post_id', $post->id)->exists()) {
            // Jika user sudah like, maka lakukan unlike
            $user->likedPosts()->detach($post);
            return response()->json(['message' => 'unliked'], 200);
        } else {
            // Jika user belum like, maka lakukan like
            $user->likedPosts()->attach($post);
            return response()->json(['message' => 'liked'], 200);
        }
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
