<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCommentFile extends Model
{
    protected $fillable = ['post_comment_id', 'file_id'];

    public function comment()
    {
        return $this->belongsTo(PostComment::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
