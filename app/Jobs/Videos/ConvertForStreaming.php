<?php

namespace Laratube\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Laratube\Video;
use FFMpeg\Format\Video\X264;
use FFMpeg;

class ConvertForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $low = (new x264('aac'))->setKiloBitrate(100); // ~ 360p
        $mid = (new x264('aac'))->setKiloBitrate(250);
        $high = (new x264('aac'))->setKiloBitrate(500);

        FFMpeg::fromDisk('local')->
                open($this->video->path)->
                exportForHLS()->
                onProgress(function ($percentage) {
                    $this->video->update(['percentage' => $percentage]);
                })->
                addFormat($low)->
                addFormat($mid)->
                addFormat($high)->
                save("public/videos/{$this->video->id}/{$this->video->id}.m3u8");
    }
}
