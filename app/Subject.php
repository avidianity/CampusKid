<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['code', 'name', 'description', 'units'];

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
