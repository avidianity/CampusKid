<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
