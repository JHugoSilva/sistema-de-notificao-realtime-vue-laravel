<?php

namespace App\Http\Controllers\Api;

use App\Events\CommentEvent;
use App\Events\LikeEvent;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeCommentController extends Controller
{

    public function postComment(Request $request) {

        $request->validate([
            'post_id' => 'required',
            'content' => 'required|min:1|max:250'
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $request->post_id,
            'content' => $request->content
        ]);

        $comment->load('user:id,first_name,last_name');

        broadcast(new CommentEvent($comment))->toOthers();

        return response()->json($comment, Response::HTTP_OK);
    }

    public function likeUnLike(Request $request, $postId) {

        $user = $request->user();
        $exists = Like::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($exists) {
            $type = 'unlike';
            $exists->delete();
        } else {
            $type = 'like';
            $like = Like::create([
                'user_id' => $user->id,
                'post_id' => $postId,
            ]);
        }

        if ($exists) {
            return response()->json(['likeId' => $exists->id], Response::HTTP_OK);
        }

        $like->load('user:id,first_name,last_name');

        $data = [
            'user_id' => $user->id,
            $like => $exists ? ['like_id' => $exists->id] : $like
        ];

        broadcast(new LikeEvent($data));

        return response()->json($like, Response::HTTP_OK);

    }
}
