<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClassLesson extends Model
{
    protected $fillable = [
        'created_by',
        'course_id',
        'schedule_id',
        'batch_id',
        'lesson_type',
        'video_type',
        'lesson_src',
        'duration',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function liveSchedule()
    {
        return $this->belongsTo(LiveClassSchedule::class, 'schedule_id'); // 'schedule_id' is the FK in lessons table
    }
    public function schedule()
    {
        return $this->belongsTo(LiveClassSchedule::class, 'schedule_id');
    }
    
}
