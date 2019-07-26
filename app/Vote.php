<?php

namespace Laratube;

class Vote extends Model
{
    public function votable()
    {
        return $this->morphTo();
    }
}
