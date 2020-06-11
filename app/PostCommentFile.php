<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCommentFile extends Model
{
    public function postComment()
    {
        return $this->belongsTo(PostComment::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
