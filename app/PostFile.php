<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
