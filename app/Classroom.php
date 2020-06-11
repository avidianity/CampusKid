<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classroom extends Model
{
    protected $fillable = ['name', 'department_id'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function subscribers()
    {
        return $this->hasMany(ClassroomSubscription::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            ClassroomSubscription::class,
            'classroom_id',
            'id',
            'id',
            'student_id'
        );
    }

    public function generateToken()
    {
        $this->token = Str::random(7);
    }
}
