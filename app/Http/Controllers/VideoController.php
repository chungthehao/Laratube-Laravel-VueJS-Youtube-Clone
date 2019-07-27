<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Http\Requests\Videos\UpdateVideoRequest;
use Laratube\Video;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        if (request()->wantsJson()) {
            return $video;
        }
        //dd($video->comments->load('replies'));
        return view('video', compact('video'));
    }

    public function updateViews(Video $video)
    {
        $video->increment('views', 1);
        return response()->json([
            'views' => $video->views
        ], Response::HTTP_OK);
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $video->update($request->only(['title', 'description']));
        return redirect()->back();
    }
}
