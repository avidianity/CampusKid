<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = ['remarks'];

    public static function alreadySubmitted($task_id, $student_id): bool
    {
        return self::where('task_id', $task_id)
            ->where('student_id', $student_id)
            ->first()
            ? true
            : false;
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
