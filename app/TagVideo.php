<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagVideo extends Model
{
    //

    public function videos()
    {
        return $this->belongsTo(Video::class);
    }
}
