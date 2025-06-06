<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    /**
     * Display a listing of the Comment.
     */
    public function index()
    {
        $comment = Comment::where('visibility', true)->get();
        return response()->json($comment, 200);
    }

    /**
     * Store a newly created Comment in storage.
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->msg_content = $request->get('msg_content');
        $comment->comments()->associate(User::findOrFail($request->get('user_id')));
        $comment->comments()->associate(Event::findOrFail($request->get('event_id')));

        $comment->save();

        return response()->json($comment, 201);
    }

    /**
     * Display the specified Comment.
     */
    public function show(Comment $comment)
    {
        return response()->json(Comment::findOrFail($comment->id)->where('visibility', true)->get(), 200);
    }

    /**
     * Update the specified Comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->msg_content = $request->get('msg_content');
        $comment->reviews()->associate(User::findOrFail($request->get('user_id')));
        $comment->reviews()->associate(Event::findOrFail($request->get('event_id')));

        $comment->save();

        return response()->json($comment, 201);
    }

    /**
     * Remove the specified Comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->visibility = false;
        $comment->save();
        return response()->json(null, 204);
    }
}
