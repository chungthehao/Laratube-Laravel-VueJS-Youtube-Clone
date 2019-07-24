<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Channel;
use Laratube\Jobs\Videos\ConvertForStreaming;

class UploadVideoController extends Controller
{
    public function index(Channel $channel)
    {
        return view('channels.upload-videos.index', [
            'channel' => $channel
        ]);
    }

    public function store(Channel $channel)
    {
        $video = $channel->videos()->create([
            'title' => request('title'),
            'path' => request('video')->store("channels/{$channel->id}"), // Upload video
        ]);

        // Dispatch a new job to convert this video for streaming.
        $this->dispatch(new ConvertForStreaming($video));

        return $video;
    }
}
