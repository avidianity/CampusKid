<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $fillable = ['name'];

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }
}
