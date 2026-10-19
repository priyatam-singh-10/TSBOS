<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClassSchedule extends Model
{
    protected $fillable = [
        'course_id',
        'batch_id',
        'title',
        'description',
        'thumbnail',
        'provider',
        'class_date_and_time',
        'additional_info',
        'curriculum'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function lessons()
    {
        return $this->hasMany(LiveClassLesson::class, 'schedule_id', 'id');
    }
}
