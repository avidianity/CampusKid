<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskSubmissionFile extends Model
{
    protected $fillable = ['task_submission_id', 'file_id'];

    public function submission()
    {
        return $this->belongsTo(TaskSubmission::class);
    }

    public function file()
    {
        return $this->hasOne(File::class);
    }
}
