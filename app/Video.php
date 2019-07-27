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

    /**
     * Get all of the video's votes.
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('comment_id');
    }
}
