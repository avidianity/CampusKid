<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classroom extends Model
{
    protected $fillable = ['name', 'department_id', 'subject_id'];

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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function profile_picture()
    {
        return $this->belongsTo(File::class, 'profile_picture_id');
    }

    public function cover_photo()
    {
        return $this->belongsTo(File::class, 'cover_photo_id');
    }

    public function generateToken()
    {
        $this->token = Str::random(7);
    }
}
