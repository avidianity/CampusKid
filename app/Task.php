<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'done',
        'classroom_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function files()
    {
        return $this->hasManyThrough(
            File::class,
            TaskFile::class,
            'task_id',
            'id',
            'id',
            'file_id'
        );
    }
}
