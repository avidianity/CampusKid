<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'department_id'];

    public function isSubscribedToClassroom($classroom_id): bool
    {
        return self::belongsToClassroom($this->id, $classroom_id);
    }

    public static function belongsToClassroom($student_id, $classroom_id): bool
    {
        return ClassroomSubscription::where('student_id', $student_id)
            ->where('classroom_id', $classroom_id)
            ->first()
            ? true
            : false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ClassroomSubscription::class);
    }

    public function classrooms()
    {
        return $this->hasManyThrough(
            Classroom::class,
            ClassroomSubscription::class,
            'student_id',
            'id'
        );
    }
}
