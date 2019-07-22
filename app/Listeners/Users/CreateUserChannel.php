<?php

namespace Laratube\Listeners\Users;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserChannel
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->channel()->create([
            'name' => $event->user->name, // Mac dinh ten channel luc dau cho = ten user luon.
        ]);
    }
}
