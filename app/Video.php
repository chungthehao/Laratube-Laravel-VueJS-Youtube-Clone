<?php

namespace Laratube;

class Video extends Model
{

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function editable()
    {
        return auth()->check() && auth()->id() === $this->channel->user_id;
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
