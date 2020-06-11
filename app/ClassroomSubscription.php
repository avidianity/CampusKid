<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassroomSubscription extends Model
{
    protected $fillable = ['student_id', 'classroom_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
