<?php

namespace Laratube;

class Vote extends Model
{

    /**
     * Get the owning votable model.
     */
    public function votable()
    {
        return $this->morphTo();
    }
}
