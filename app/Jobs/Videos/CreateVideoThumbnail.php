<?php

namespace Laratube\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use FFMpeg;
use Illuminate\Support\Facades\Storage;

class CreateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
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
        // Tạo thumbnail và lưu file
        FFMpeg::fromDisk('local')
            ->open($this->video->path)
            ->getFrameFromSeconds(1) // Lay frame vao thoi diem 1s cua video
            ->export()
            ->toDisk('local')
            ->save("public/thumbnails/{$this->video->id}.png");

        // Lưu vào db duong link de truy cap bang browser
        $this->video->update(['thumbnail' => Storage::url("public/thumbnails/{$this->video->id}.png")]);
    }
}
