<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Comment;
use Laratube\Video;

class CommentController extends Controller
{
    public function index(Video $video)
    {
        return $video->comments()->with(['user', 'votes'])->paginate(3); // 3 comments per "page"
    }

    public function getReplies(Comment $comment)
    {
        return $comment->replies()->with(['user', 'votes'])->paginate(3);
    }

    public function store(Request $request, Video $video)
    {
        return auth()->user()->comments()->create([
            'body' => $request->body,
            'comment_id' => $request->comment_id, // Khác null nếu nó là reply cho 1 comment nào đó
            'video_id' => $video->id,
        ])->load(['user', 'votes', 'replies']);
    }
}
