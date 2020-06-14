<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = ['body', 'classroom_id', 'user_id'];

    public function saveFiles(Request $request)
    {
        $files = File::saveFrom($request);
        $this->files = [];
        foreach ($files as $file) {
            $post_file = new PostFile([
                'post_id' => $this->id,
                'file_id' => $file->id,
            ]);
            $post_file->save();
            $this->files[] = $post_file;
        }
        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
