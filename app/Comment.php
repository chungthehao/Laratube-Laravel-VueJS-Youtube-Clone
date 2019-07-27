<?php

namespace Laratube;

class Comment extends Model
{
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class); // Tự nó tìm comment_id match với của nó
    }
}
