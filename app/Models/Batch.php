<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'bundle_id',
        'name',
        'start_date',
        'end_date',
        'no_of_live_class',
        'max_students',
        'batch_price',
        'description',
        'status',
        'thumbnail',
    ];
    protected $casts = [
        'course_id' => 'array',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'batch_id', 'user_id');
    }
    //public function liveClasses()
    // {
    //     return $this->hasMany(Live_class::class, 'batch_id', 'id');
    // }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'batch_id', 'id')
            ->whereColumn('lessons.course_id', 'batches.course_id');
    }
    public function liveClassLessons()
    {
        return $this->hasMany(LiveClassLesson::class, 'batch_id', 'id');
    }
    public function livecourses()
    {
        $ids = json_decode($this->course_id, true);

        if (!$ids) {
            return collect();
        }

        return Course::whereIn('id', $ids)->get();
    }
    public function liveClassSchedules()
    {
        return $this->hasMany(LiveClassSchedule::class, 'batch_id');
    }
}
