<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Channel;
use Laratube\Video;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $videos = collect();
        $channels = collect();
        if ($search = request('search')) {
            $videos = Video::where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->paginate(5, ['*'], 'video_page');

            $channels = Channel::where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->paginate(5, ['*'], 'channel_page');
        }

        return view('home', compact('videos', 'channels'));
    }
}
