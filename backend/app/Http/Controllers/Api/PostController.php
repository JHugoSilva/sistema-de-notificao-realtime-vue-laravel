<?php

namespace App\Http\Controllers\Api;

use App\Events\PostEvent;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $posts = Post::with(['user:id,first_name,last_name','comments.user:id,first_name,last_name','likes.user:id,first_name,last_name'])
            ->withCount(['likes', 'comments'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
                ->cursorPaginate();

        return response()->json($posts, Response::HTTP_OK);
    }

    public function publicPosts()
    {
        $posts = Post::with(['user:id,first_name,last_name','comments.user:id,first_name,last_name','likes.user:id,first_name,last_name'])
        ->withCount(['likes', 'comments'])
        ->where('visibility', 'public')
            ->orderBy('created_at', 'desc')
                ->cursorPaginate();

        return response()->json($posts, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'mimes:png,jpg,jpeg'
            ]);

            $image = $request->file('image');
            $path = $image->store('post_images');

        } else {

            $request->validate([
                'text' => 'required|min:5'
            ]);
        }

        $post = Post::create([
            'user_id' => $request->user()->id,
            'text' => $request->text ?? null,
            'image' => $path ?? null,
            'visibility' => $request->visibility ?? 'public'
        ]);

        $post->load(['user:id,first_name,last_name','comments.user:id,first_name,last_name','likes.user:id,first_name,last_name'])
            ->loadCount(['likes', 'comments']);

        broadcast(new PostEvent($post));

        return response()->json([
            'message' => 'Post Created',
            'data' => $post
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'visibility' => 'in:public,private',
            'text' => 'min:5'
        ]);

        $post->update($request->only(['text', 'visibility']));

        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post = $post->delete();
        if (!$post) {
            return response()->json(['message' => 'Post Not Found'], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Post Deleted Successfully'], Response::HTTP_OK);
    }
}
