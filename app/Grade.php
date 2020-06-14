<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['preliminaries', 'midterms', 'finals'];

    public static function alreadyExists($student_id, $classroom_id): bool
    {
        return self::where('student_id', $student_id)
            ->where('classroom_id', $classroom_id)
            ->first()
            ? true
            : false;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
