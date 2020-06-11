<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'address',
    ];

    protected $dates = ['birthday'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
