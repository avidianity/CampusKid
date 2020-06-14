<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    protected $fillable = ['task_id', 'file_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
