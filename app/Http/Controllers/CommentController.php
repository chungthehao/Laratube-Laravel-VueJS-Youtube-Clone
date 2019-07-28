<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Comment;
use Laratube\Video;

class CommentController extends Controller
{
    public function index(Video $video)
    {
        return $video->comments()->with(['user'])->paginate(3); // 3 comments per "page"
    }

    public function getReplies(Comment $comment)
    {
        return $comment->replies()->with(['user'])->paginate(3);
    }
}
