<?php

namespace Laratube;

class Comment extends Model
{
    protected $appends = ['total_replies'];

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
        return $this->hasMany(Comment::class)->latest(); // Tự nó tìm comment_id match với của nó
    }

    public function getTotalRepliesAttribute()
    {
        return $this->replies()->count();
    }
}
